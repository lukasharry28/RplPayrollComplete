<?php

namespace App\Http\Controllers\Admin;

use App\{Employee, Payroll, Deduction, Overtime, Attendance, Company, PayrollSchedule};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
// use Vendor\PDF;
use Barryvdh\DomPDF\PDF;

use LOG;
// use Spatie\MediaLibrary\ImageGenerators\FileTypes\Pdf;

class PayrollController extends Controller
{
    private $folder = "admin.payroll.";

    public function index()
    {
        // dd($payrolls);
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData()
    {
        $payrolls = Payroll::all();
        return View($this->folder.'content',[
            'add_new' => "/",
            'getDataTable' => route($this->folder.'getDataTable'),
            'payroll_url' => route($this->folder."payrollExportPDF"),
            'payslip_url' => route($this->folder."payslipExportPDF"),
            'payrolls'=>$payrolls,
        ]);
    }

    public function getDataTable()
    {
        $payrolls = Payroll::with([
            'employee',
            'employee.rekening.bank',
            'employee.position',
            'employee.tunjangan',
            'employee.pajak',
            'employee.deduction'
        ])->get();

        Log::debug('Payrolls Data:', ['payrolls' => $payrolls]);


        return DataTables::of($payrolls)
            ->addIndexColumn()
            ->addColumn('detail pegawai', function ($data) {
                return "<div>
                            <span>{{ $data->employee->employee_id }}</span><br>
                                <b><span>{{ $data->employee->first_name }} </span></b>
                                <b><span>{{ $data->employee->last_name }}</span></b>
                        </div>";
            })
            ->addColumn('rekening', function ($data) {
                return "<div>
                          <b>No Rekening:</b> <span>{$data->employee->rekening->no_rekening}</span><br>
                          <b>Bank:</b> <span></span>{$data->employee->rekening->bank->bank_name}<br>
                        </div>";
            })
            ->addColumn('posisi', function ($data) {
                return $data->employee->position->title;
            })
            ->addColumn('tanggal pay', function ($data) {
                return $data->date;
            })
            ->addColumn('gaji', function ($data) {
                return number_format($data->employee->salary, 2);
            })
            ->addColumn('tunjangan', function ($data) {
                return "<div>
                            <b>Jenis:</b> <span>{$data->employee->tunjangan->title}</span><br>
                            <b>Nominal:</b> <span>{$data->employee->tunjangan->rate_amount}</span><br>
                        </div>";
            })
            ->addColumn('pajak', function ($data) {
                return "<div>
                            <b>Jenis:</b> <span>{$data->employee->pajak->title}</span><br>
                            <b>Nominal:</b> <span>{$data->employee->pajak->tax_amount}</span><br>
                        </div>";
            })
            ->addColumn('potongan', function ($data) {
                return "<div>
                            <b>Jenis:</b> <span>{$data->employee->deduction->name}</span><br>
                            <b>Nominal:</b> <span>{$data->employee->deduction->amount}</span><br>
                        </div>";
            })
            ->addColumn('status payroll', function ($data) {
                return $data->payroll_status;
            })
            ->addColumn('total gaji', function ($data) {
                return number_format($data->total_amount, 2);
            })
            ->addColumn('action', function ($data) {
                return '<button class="btn btn-sm btn-primary">Edit</button>';
            })

            ->rawColumns(['detail pegawai', 'rekening', 'posisi', 'tanggal pay', 'gaji', 'tunjangan', 'pajak', 'potongan', 'status payroll', 'total gaji', 'action'])
            ->toJson();
    }


    public function exportPayrollPDF(Request $request)
{
    // Validasi input tanggal
    $request->validate([
        'date' => 'required|string'
    ]);

    // Parsing tanggal
    $dates = explode(' - ', $request->input('date'));
    $startDate = Carbon::parse($dates[0])->startOfDay();
    $endDate = Carbon::parse($dates[1])->endOfDay();

    // Ambil data payroll
    $payrolls = Payroll::with([
        'employee',
        'employee.rekening',
        'employee.rekening.bank',
        'employee.position',
        'employee.tunjangan',
        'employee.pajak',
        'employee.deduction'
    ])
    ->whereBetween('date', [$startDate, $endDate])
    ->get();

    // Generate PDF
    $pdf = PDF::loadView('admin.payroll.export.payroll', [
        'payrolls' => $payrolls,
        'date' => $request->input('date')
    ])->setPaper('a4', 'landscape');

    // Nama file dinamis
    $fileName = "payroll-" . date("d-M-Y") . ".pdf";

    // Langsung download
    return $pdf->download($fileName);
}


    // public function payrollExportPDF(Request $request)
    // {
    //     $payrolls = $this->payroll($request);

    //     $pdf = PDF::loadView($this->folder."export.payroll",[
    //         'payrolls'=> $payrolls,
    //         'date'=> $request->date,
    //     ]);

    //     $fileName = "payroll-".date("d-M-Y")."-".time().'.pdf';
    //     return $pdf->download($fileName);
    // }

    // public function payslipExportPDF(Request $request)
    // {
    //     $payslips = $this->payroll($request);

    //     $pdf = PDF::loadView($this->folder."export.payslip",[
    //         'payrolls'=> $payslips,
    //         'date'=> $request->date,

    //     ]);

    //     $fileName = "payslip-".date("d-M-Y")."-".time().'.pdf';
    //     return $pdf->download($fileName);
    // }

    public function create()
    {
        return view($this->folder . 'create', [
            'form_store' => route($this->folder.'store'),
            'employees' => Employee::all(),
            'companies' => Company::all(),
            'payschedules' => PayrollSchedule::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companys,company_id',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
        ]);

        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($validatedData['employee_id']);
            $company = Company::findOrFail($validatedData['company_id']);

            $payroll = new Payroll($validatedData);
            $payroll->retrieveEmployeeBenefits();
            $payroll->total_amount = $payroll->calculateTotalAmount();
            $payroll->payroll_status = 'Success';

            // if ($company->rekening->saldo < $payroll->total_amount) {
            //     DB::rollBack();
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Saldo perusahaan tidak mencukupi untuk membuat payroll.',
            //         'redirect_to' => route($this->folder.'index')
            //     ]);
            // }

            $companySaldo = (float) $company->rekening->saldo;
            $payrollAmount = (float) $payroll->total_amount;
            $employeeSaldo = (float) $employee->rekening->saldo;

            // Validasi tipe data angka
            if (!is_numeric($companySaldo) || !is_numeric($payrollAmount)) {
                throw new \Exception('Saldo atau total amount bukan angka yang valid.');
            }
            if (bccomp($companySaldo,  $payrollAmount, 2) < 0) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Saldo perusahaan tidak mencukupi untuk membuat payroll.',
                    'redirect_to' => route($this->folder.'index')
                ]);
            }
            $company->load('rekening');
            // Operasi aritmatika dengan presisi dua desimal
            $companySaldo = $companySaldo - $payrollAmount;// Kurangi saldo perusahaan
            $employeeSaldo = $employeeSaldo + $payrollAmount; // Tambahkan saldo ke karyawan

            // Simpan hasil ke objek rekening
            $rekeningCompany = $company->rekening;
            $rekeningCompany->saldo = $companySaldo; // Update saldo perusahaan
            $rekeningCompany->save(); // Simpan ke database

            // Simpan hasil ke objek karyawan
            $rekeningEmployee = $employee->rekening;
            $rekeningEmployee->saldo = $employeeSaldo; // Update saldo karyawan
            $rekeningEmployee->save(); // Simpan ke database

            $company->save();
            $employee->save();
            $payroll->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Payroll baru berhasil dibuat.',
                'redirect_to' => route($this->folder.'index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
        }
    }



    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,company_id',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'payroll_status' => 'required|in:Pending,Success,Failed',
            'payschedule_id' => 'required|exists:payrollschedules,payschedule_id',
        ]);

        // Cari data Payroll yang akan diperbarui
        $payroll = Payroll::findOrFail($id);

        // Update data payroll dengan input baru
        $payroll->employee_id = $request->employee_id;
        $payroll->company_id = $request->company_id;
        $payroll->date = $request->date;
        $payroll->payroll_status = $request->payroll_status;
        $payroll->payschedule_id = $request->payschedule_id;
        $payroll->save();

        // Redirect atau kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.payroll.index')->with('success', 'Payroll berhasil diperbarui!');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return response()->json([
                'status' => true,
                'message' => "Your Record has been Deleted!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
    }
}
