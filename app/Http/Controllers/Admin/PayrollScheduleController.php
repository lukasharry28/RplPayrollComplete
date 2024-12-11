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
use Illuminate\Support\Facades\DB;

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
            ->addColumn('waktu payroll', function ($data) {
                return $data->payroll_time;
            })
            ->addColumn('status payroll', function ($data) {
                return $data->payroll_status;
            })
            ->rawColumns(['company_id', 'tanggal payroll', 'waktu payroll', 'status payroll'])
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
            // 'company_id' => 'required|exists:companys,company_id',
            'payroll_date' => 'required|date|after_or_equal:today',
            'payroll_time' => 'required|date_format:H:i'
        ]);

        $schedule = new PayrollSchedule($validatedData);
        $schedule->company_id = '1';
        $schedule->payroll_status = 'Progress';
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
        $now = Carbon::now();

        // Cari jadwal payroll untuk hari ini dengan waktu yang cocok
        $schedules = PayrollSchedule::whereDate('payroll_date', $now->toDateString())
            ->whereTime('payroll_time', '<=', $now->format('H:i:s'))
            ->whereTime('payroll_time', '>', $now->subMinutes(5)->format('H:i:s'))
            ->where('payroll_status', 'Progress') // Hindari proses ulang
            ->get();

        foreach ($schedules as $schedule) {
            $employees = Employee::all();
            foreach ($employees as $employee) {
                $payroll = new Payroll();
                $payroll->employee_id = $employee->id;
                $payroll->company_id = $schedule->company_id;
                $payroll->payschedule_id = $schedule->payschedule_id;
                $payroll->retrieveEmployeeBenefits();
                $payroll->total_amount = $this->calculatePayrollAmount($employee);
                $payroll->payroll_status = 'Pending';
                $payroll->save();

                $companySaldo = (float) $schedule->company->rekening->saldo;
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
                $schedule->company->load('rekening');
                // Operasi aritmatika dengan presisi dua desimal
                $companySaldo = $companySaldo - $payrollAmount;// Kurangi saldo perusahaan
                $employeeSaldo = $employeeSaldo + $payrollAmount; // Tambahkan saldo ke karyawan

                // Simpan hasil ke objek rekening
                $rekeningCompany = $schedule->company->rekening;
                $rekeningCompany->saldo = $companySaldo; // Update saldo perusahaan
                $rekeningCompany->save(); // Simpan ke database

                // Simpan hasil ke objek karyawan
                $rekeningEmployee = $employee->rekening;
                $rekeningEmployee->saldo = $employeeSaldo; // Update saldo karyawan
                $rekeningEmployee->save(); // Simpan ke database

                $schedule->company->save();
                $employee->save();
                $payroll->save();

                DB::commit();
            }
        }

        return response()->json(['message' => 'Payroll baru berhasil dibuat untuk hari ini.']);
    }

    public function edit($id)
    {
        $payrollschedule = PayrollSchedule::findOrFail($id);
        $companys = Company::all();

        return view($this->folder . 'edit', [
            'payrollschedule' => $payrollschedule,
            'form_update' => route($this->folder.'update', $payrollschedule),
            'companys' => $companys
        ]);
    }

    public function update(Request $request, $id)
    {
        $payrollschedule = PayrollSchedule::findOrFail($id);

        $validatedData = $request->validate([
            'payroll_date' => 'required|date|after_or_equal:today',
            'payroll_time' => 'required|date_format:H:i'
        ]);

        $payrollschedule->fill($validatedData);
        $payrollschedule->save();

        return response()->json([
            'status' => true,
            'message' => 'Jadwal Payroll berhasil diperbarui.',
            'redirect_to' => route($this->folder.'index')
        ]);
    }

    public function destroy($id)
    {
        try {
            $payrollschedule = PayrollSchedule::findOrFail($id);
            $payrollschedule->delete();

            return response()->json([
                'status' => true,
                'message' => 'Jadwal Payroll berhasil dihapus.',
                'getDataUrl' => route($this->folder.'getData'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus Jadwal Payroll: ' . $e->getMessage()
            ], 500);
        }
    }
}
