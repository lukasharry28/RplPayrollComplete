<?php

namespace App\Http\Controllers\Admin;

use App\{Employee, Payroll, Deduction, Overtime, Attendance, Company, PayrollSchedule};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;
use PDF;
use LOG;

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
            ->addColumn('id pegawai', function ($data) {
                return $data->employee_id;
            })
            ->addColumn('nama pegawai', function ($data) {
                return $data->first_name . ' ' . $data->last_name;
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
            ->rawColumns(['id pegawai', 'nama pegawai', 'rekening', 'posisi', 'tanggal pay', 'gaji', 'tunjangan', 'pajak', 'potongan', 'status payroll', 'total gaji'])
            ->toJson();
    }

    public function payrollExportPDF(Request $request)
    {
        $payrolls = $this->payroll($request);

        $pdf = PDF::loadView($this->folder."export.payroll",[
            'payrolls'=> $payrolls,
            'date'=> $request->date,
            'deduction_amount' => Deduction::sum("amount")
        ]);

        $fileName = "payroll-".date("d-M-Y")."-".time().'.pdf';
        return $pdf->download($fileName);
    }

    public function payslipExportPDF(Request $request)
    {
        $payslips = $this->payroll($request);

        $pdf = PDF::loadView($this->folder."export.payslip",[
            'payrolls'=> $payslips,
            'date'=> $request->date,
            'deduction_amount'=> Deduction::sum("amount"),
        ]);

        $fileName = "payslip-".date("d-M-Y")."-".time().'.pdf';
        return $pdf->download($fileName);
    }

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
            $payroll->payroll_status = 'Pending';

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

    public function destroy($id)
    {
        // Cari data Payroll yang akan dihapus
        $payroll = Payroll::findOrFail($id);

        // Hapus data payroll
        $payroll->delete();

        // Redirect atau kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.payroll.index')->with('success', 'Payroll berhasil dihapus!');
    }
}
