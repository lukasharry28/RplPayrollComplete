<?php

namespace App\Http\Controllers\Admin;

use App\{Employee, Payroll, Deduction, Overtime, Attendance, Company};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use PDF;

class PayrollController extends Controller
{
    private $folder = "admin.payroll.";

    public function index()
    {
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData()
    {
        return View($this->folder.'content',[
            'add_new' => "/",
            'getDataTable' => route($this->folder.'getDataTable'),
            'payroll_url' => route($this->folder."payrollExportPDF"),
            'payslip_url' => route($this->folder."payslipExportPDF"),
        ]);
    }

    public function getDataTable()
    {
        $payrolls = Payroll::with([
            'employee.rekening.bank',
            'employee.position',
            'employee.tunjangan',
            'employee.pajak',
            'employee.deduction'
        ])->get();

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
                return $data->pay_date;
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

    // private function payroll($request)
    // {
    //     $date = explode(' - ', $request->date);
    //     $start_date = date("Y-m-d", strtotime($date[0]));
    //     $end_date = date("Y-m-d", strtotime($date[1]));

    //     // Get employee IDs who have attendance between the selected date range
    //     $attendances = Attendance::whereBetween("date",[$start_date,$end_date])->pluck('employee_id')->toArray();
    //     $empIds = array_unique($attendances);

    //     // Retrieve employee data with related models (over time, deduction, attendance)
    //     $payrolls = Payroll::with([
    //         'employee' => function($q) use ($empIds) {
    //             $q->whereIn('id', $empIds);
    //         },
    //         'deduction',
    //         'employee.overtimes',
    //         'employee.attendances'
    //     ])->whereIn("employee_id", $empIds)->get();

    //     return $payrolls;
    // }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,company_id',
            'date' => 'required|date',
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
