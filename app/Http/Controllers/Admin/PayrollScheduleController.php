<?php

// app/Http/Controllers/PayrollController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payroll;
use App\Company;
use App\PayrollSchedule;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\log;
use Yajra\DataTables\Facades\DataTables;

class PayrollScheduleController  extends Controller
{

    private $folder = "admin.payrollschedule.";

    public function index()
    {
        // dd($payrolls);
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData()
    {
        $payrollschdedules = PayrollSchedule::all();
        return View($this->folder.'content',[
            'add_new' => "/",
            'getDataTable' => route($this->folder.'getDataTable'),
            'payrollschdedules'=>$payrollschdedules,
        ]);
    }

    public function getDataTable()
    {
        $payrollschd = PayrollSchedule::with(['company']);

        Log::debug('Payrolls Data:', ['payrolls' => $payrollschd]);

        return DataTables::of($payrollschd)
        ->addIndexColumn()
            ->addColumn('company_id', function ($data) {
                return $data->company_id;
            })
            ->addColumn('tanggal payroll', function ($data) {
                return $data->payroll_date;
            })
            ->addColumn('status payroll', function ($data) {
                return $data->payroll_status;
            })
            ->rawColumns(['company_id', 'tanggal payroll', 'status payroll'])
            ->toJson();
    }

    public function create()
    {
        return view($this->folder . 'create', [
            'form_store' => route($this->folder.'store'),
            'companys' => Company::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,company_id',
            'payroll_date' => 'required|date|after_or_equal:today',
            'payroll_status' => 'required|string',
        ]);

        $schedule = new PayrollSchedule($validatedData);
        $schedule->save();

        return response()->json([
            'status' => true,
            'message' => 'Jadwal Payroll baru berhasil dibuat.',
            'redirect_to' => route($this->folder.'index')
        ]);

    }

    // public function storeSchedule(Request $request)
    // {
    //     // Validasi dan penyimpanan jadwal payroll
    //     $validatedData = $request->validate([
    //         'company_id' => 'required|exists:companies,company_id',
    //         'payroll_date' => 'required|date|after_or_equal:today',
    //         'payroll_status' => 'required|string',
    //     ]);

    //     $schedule = new PayrollSchedule($validatedData);
    //     $schedule->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Jadwal Payroll baru berhasil dibuat.',
    //         'redirect_to' => route($this->folder.'index')
    //     ]);
    // }

    public function generatePayroll()
    {
        $today = Carbon::today();
        $schedules = PayrollSchedule::whereDate('payroll_date', $today)->get();

        foreach ($schedules as $schedule) {
            $employees = Employee::all();
            foreach ($employees as $employee) {
                $payroll = new Payroll();
                $payroll->employee_id = $employee->id;
                $payroll->company_id = $schedule->company_id;
                $payroll->payschedule_id = $schedule->payschedule_id;
                $payroll->total_amount = $this->calculatePayrollAmount($employee);
                $payroll->payroll_status = 'Pending';
                $payroll->save();
            }
        }

        return response()->json(['message' => 'Payroll baru berhasil dibuat untuk hari ini.']);
    }
}
