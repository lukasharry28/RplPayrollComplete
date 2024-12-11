<?php

namespace App\Http\Controllers\Admin;

use App\{Employee,Attendance};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    private $folder = "admin.attendance.";

    public function index()
    {
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData(){
        return View($this->folder.'content',[
            'add_new' => route($this->folder.'create'),
            'getDataTable' => route($this->folder.'getDataTable'),
            'moveToTrashAllLink' => route($this->folder.'massDelete'),
        ]);
    }

    public function getDataTable(Request $request) {
        $attendance = Attendance::query();

        // Filter berdasarkan 'date' spesifik
        if ($request->groupBy === 'date' && $request->filterDate) {
            $attendance->whereDate('date', $request->filterDate);
        }
        // Filter berdasarkan 'month' spesifik
        elseif ($request->groupBy === 'month' && $request->filterMonth) {
            $dateParts = explode('-', $request->filterMonth);
            if (count($dateParts) == 2) {
                $year = $dateParts[0];
                $month = $dateParts[1];
                $attendance->whereYear('date', $year)->whereMonth('date', $month);
            }
        }
        // Filter berdasarkan 'year' spesifik
        elseif ($request->groupBy === 'year' && $request->filterYear) {
            $attendance->whereYear('date', $request->filterYear);
        }
        // Filter berdasarkan status 'ontime' atau 'late'
        elseif ($request->groupBy === 'ontime') {
            $attendance->where('ontime_status', 1);
        } elseif ($request->groupBy === 'late') {
            $attendance->where('ontime_status', 0);
        }

        // Proses data untuk DataTables
        return Datatables::of($attendance)
            ->addIndexColumn()
            ->addColumn('employee', function($data) {
                return "<div class='row'><div class='col-md-3 text-center'><img src='".$data->employee->media_url['thumb']."' class='rounded-circle table-user-thumb'></div><div class='col-md-6 col-lg-6 my-auto'><b class='mb-0'>".$data->employee->first_name." ".$data->employee->last_name."</b><p class='mb-2' title='".$data->employee->employee_id."'><small><i class='ik ik-at-sign'></i>".$data->employee->employee_id."</small></p></div><div class='col-md-4 col-lg-4'><small class='text-muted float-right'></small></div></div>";
            })
            ->addColumn('action', function($data) {
                $btn = "<div class='table-actions'>
                <a href='".route($this->folder."edit", ['id' => $data->id])."'><i class='ik ik-edit-2 text-dark'></i></a>
                <a data-href='".route($this->folder."destroy", ['id' => $data->id])."' class='delete cursure-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
                </div>";
                return $btn;
            })
            ->addColumn('time_in_details', function($data) {
                $status = "<div><span class='float-left'>".$data->time_in."</span>";
                $status .= "<span class='float-right'>";
                $status .= !$data->ontime_status ? "<span class='text-danger'>LATE</span>" : "<span class='text-primary'>ONTIME</span>";
                $status .= "</span></div>";
                return $status;
            })
            ->addColumn('work_hr', function($data) {
                // Pastikan time_in dan time_out ada sebelum perhitungan
                if ($data->time_in && $data->time_out) {
                    $timeIn = new \DateTime($data->time_in);
                    $timeOut = new \DateTime($data->time_out);

                    // Hitung selisih waktu
                    $interval = $timeIn->diff($timeOut);
                    $hoursWorked = $interval->h + ($interval->i / 60); // Menghitung jam termasuk menit

                    return round($hoursWorked, 2) . " hr"; // Tampilkan hasil perhitungan
                } else {
                    return "0 hr"; // Jika time_out kosong, tampilkan 0
                }
            })

            ->rawColumns(['employee', 'action', 'time_in_details', 'work_hr'])
            ->toJson();
    }

    // public function getDataTable(){
    //     $attendance = Attendance::latest();
    //     return Datatables::of($attendance)
    //                 ->addIndexColumn()
    //                 ->addColumn('employee', function($data){
    //                 	return "<div class='row'><div class='col-md-3 text-center'><img src='".$data->employee->media_url['thumb']."' class='rounded-circle table-user-thumb'></div><div class='col-md-6 col-lg-6 my-auto'><b class='mb-0'>".$data->employee->first_name." ".$data->employee->last_name."</b><p class='mb-2' title='".$data->employee->employee_id."'><small><i class='ik ik-at-sign'></i>".$data->employee->employee_id."</small></p></div><div class='col-md-4 col-lg-4'><small class='text-muted float-right'></small></div></div>";
    //                 })
    //                 ->addColumn('action', function($data){
    //                         $btn = "<div class='table-actions'>
    //                         <a href='".route($this->folder."edit",['id'=>$data->id])."'><i class='ik ik-edit-2 text-dark'></i></a>
    //                         <a data-href='".route($this->folder."destroy",['id'=>$data->id])."' class='delete cursure-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
    //                         </div>";
    //                         return $btn;
    //                 })
    //                 ->addColumn('time_in_details', function($data){
    //                         $status = "<div>";
    //                         $status .= "<span class='float-left'>";
    //                         $status.= $data->time_in;
    //                         $status .= "</span>";
    //                         $status .= "<span class='float-right'>";
    //                         if(!$data->ontime_status){
    //                         $status.= "<span class='text-danger'>LATE</span>";
    //                         }else{
    //                         $status.= "<span class='text-primary'>ONTIME</span>";
    //                         }
    //                         $status .= "</span>";
    //                         return $status;
    //                 })
    //                 ->addColumn('work_hr', function($data){
    //                         return $data->num_hour."/hr";
    //                 })
    //                 ->rawColumns(['employee','action','time_in_details','work_hr'])
    //                 ->toJson();
    // }

    public function create()
    {
        $employees = Employee::get();
        return View($this->folder."create",[
            'form_store' => route($this->folder.'store'),
            'employees' => $employees,
        ]);
    }

    public function store(AttendanceRequest $request)
    {
        $data = [
            'date' => $request->date,
            'employee_id' => $request->employee_id,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'num_hour' => 0,
        ];
        $attendance = Attendance::create($data);

        return response()->json([
            'status'=>true,
            'message'=>'New Attendance added successfully.',
            'redirect_to' => route($this->folder.'index')
            ]);
    }

    public function show(Attendance $attendance){
        abort(404);
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::get();
        return View($this->folder.'edit',[
            'attendance' => $attendance,
            'form_update' => route($this->folder.'update',['attendance'=>$attendance]),
            'employees' => $employees,
        ]);
    }

    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $data = [
            'date' => $request->date,
            'employee_id' => $request->employee_id,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out
        ];
        $attendance->update($data);

        return response()->json([
            'status'=>true,
            'message'=> 'Attendance updated successfully.',
            'redirect_to' => route($this->folder.'index')
            ]);
    }

    public function destroy(Request $request,$id)
    {
        $trash = Attendance::where('id',$id)->delete();
        if($trash){
            return response()->json([
                'status' => true,
                'message' => "Your Record has been Permanent Delete!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "Something went wrong please try later!",
            'getDataUrl' => route($this->folder.'getData'),
        ]);
    }

    public function massDelete(Request $request){

    	$trash = Attendance::whereIn('id',$request->ids)
                        ->delete();

        if($trash){
            return response()->json([
                'status' => true,
                'message' => "Your Record has been Permanent Delete!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "Something went wrong please try later!",
            'getDataUrl' => route($this->folder.'getData'),
        ]);
    }
}
