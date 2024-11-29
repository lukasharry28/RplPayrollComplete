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

    public function getDataTable(Request $request)
    {
        $payroll = $this->payroll($request);

        return Datatables::of($payroll)
                    ->addIndexColumn()
                    ->addColumn('employee', function($data){
                        return "<div class='row'><div class='col-md-3 text-center'><img src='".$data->employee->media_url['thumb']."' class='rounded-circle table-user-thumb'></div><div class='col-md-6 col-lg-6 my-auto'><b class='mb-0'>".$data->employee->first_name." ".$data->employee->last_name."</b><p class='mb-2' title='".$data->employee->employee_id."'><small><i class='ik ik-at-sign'></i>".$data->employee->employee_id."</small></p></div><div class='col-md-4 col-lg-4'><small class='text-muted float-right'></small></div></div>";
                    })
                    ->addColumn('gross', function($data){
                        return number_format($data->employee->gross_amount,2);
                    })
                    ->addColumn('deduction', function($data){
                        return number_format($data->deduction,2);
                    })
                    ->addColumn('total_amount', function($data){
                        return "<b>Rs.".number_format($data->total_amount,2)."</b>";
                    })
                    ->rawColumns(['employee','gross','deduction','total_amount'])
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

    private function payroll($request)
    {
        $date = explode(' - ', $request->date);
        $start_date = date("Y-m-d", strtotime($date[0]));
        $end_date = date("Y-m-d", strtotime($date[1]));

        // Get employee IDs who have attendance between the selected date range
        $attendances = Attendance::whereBetween("date",[$start_date,$end_date])->pluck('employee_id')->toArray();
        $empIds = array_unique($attendances);

        // Retrieve employee data with related models (over time, deduction, attendance)
        $payrolls = Payroll::with([
            'employee' => function($q) use ($empIds) {
                $q->whereIn('id', $empIds);
            },
            'deduction',
            'employee.overtimes',
            'employee.attendances'
        ])->whereIn("employee_id", $empIds)->get();

        return $payrolls;
    }

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
