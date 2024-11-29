<?php

namespace App\Http\Controllers\Admin;

use App\{Employee, Schedule, Position};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use DataTables;

class EmployeeController extends Controller
{
    private $folder = "admin.employee.";

    public function index()
    {
        return view($this->folder . 'index', [
            'get_data' => route($this->folder . 'getData'),
        ]);
    }

    public function getData()
    {
        return view($this->folder . 'content', [
            'add_new' => route($this->folder . 'create'),
            'getDataTable' => route($this->folder . 'getDataTable'),
            'moveToTrashAllLink' => route($this->folder . 'massDelete'),
            'employees' => Employee::get(),
        ]);
    }

    public function getDataTable()
    {
        $employees = Employee::with(['position', 'schedule'])->get();

        return Datatables::of($employees)
            ->addIndexColumn()
            ->addColumn('avatar', function ($data) {
                $avatar = "<img src='" . $data->media_url['thumb'] . "' class='table-user-thumb'>";
                return $avatar;
            })
            ->addColumn('is_active', function ($data) {
                return $data->is_active
                    ? "<span class='success-dot' title='Active Employee'></span>"
                    : "<i class='ik ik-alert-circle text-danger alert-status' title='Inactive Employee'></i>";
            })
            ->addColumn('details', function ($data) {
                $details = "<div>
                            <b>NIK:</b> <span>{$data->nik}</span><br>
                            <b>Gender:</b> <span>{$data->gender}</span><br>
                            <b>Schedule:</b> <span>{$data->schedule->time_in}-{$data->schedule->time_out}</span><br>
                            <b>Address:</b> <span>{$data->address}</span><br>
                        </div>";
                return $details;
            })
            ->addColumn('position', function ($data) {
                return $data->position->title ?? '-';
            })
            ->addColumn('action', function ($data) {
                $btn = "<div class='table-actions'>
                            <a data-href='" . route($this->folder . 'show', ['employee_id' => $data->employee_id]) . "' class='show-employee cursor-pointer'><i class='ik ik-eye text-primary'></i></a>
                            <a href='" . route($this->folder . "edit", ['employee_id' => $data->employee_id]) . "'><i class='ik ik-edit-2 text-dark'></i></a>
                            <a data-href='" . route($this->folder . "destroy", ['id' => $data->id]) . "' class='delete cursor-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
                        </div>";
                return $btn;
            })
            ->rawColumns(['action', 'avatar', 'is_active', 'position', 'details'])
            ->toJson();
    }

    public function create()
    {
        return view($this->folder . "create", [
            'form_store' => route($this->folder . 'store'),
            'schedules' => Schedule::get(),
            'positions' => Position::get(),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->only([
            'nik', 'first_name', 'last_name', 'gender', 'tgl_lahir', 'tmp_lahir',
            'agama', 'gol_darah', 'status_nikah', 'phone', 'email',
            'address', 'remark', 'schedule_id', 'position_id',
            'rate_per_hour', 'salary', 'is_active', 'tunjangan_id', 'pajak_id', 'id_rekening'
        ]);

        $employee = Employee::create($data);

        if ($request->has('media') && file_exists(storage_path('media/uploads/' . $request->input('media')))) {
            $media = $employee->addMedia(storage_path('media/uploads/' . $request->input('media')))->toMediaCollection('avatar');
            $employee->media_id = $media->id;
            $employee->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'New Employee created successfully.',
            'redirect_to' => route($this->folder . 'index'),
        ]);
    }

    public function edit(Employee $employee)
    {
        return view($this->folder . 'edit', [
            'employee' => $employee,
            'form_update' => route($this->folder . 'update', ['employee' => $employee]),
            'schedules' => Schedule::get(),
            'positions' => Position::get(),
            'removeAvatar' => route('admin.removeMedia', [
                'model' => 'Employee',
                'model_id' => $employee->id,
                'collection' => 'avatar',
            ]),
        ]);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->only([
            'nik', 'first_name', 'last_name', 'gender', 'tgl_lahir', 'tmp_lahir',
            'agama', 'gol_darah', 'status_nikah', 'phone', 'email',
            'address', 'remark', 'schedule_id', 'position_id',
            'rate_per_hour', 'salary', 'is_active', 'tunjangan_id', 'pajak_id', 'id_rekening'
        ]);

        $employee->update($data);

        if ($request->has('media') && file_exists(storage_path('media/uploads/' . $request->input('media')))) {
            $media = $employee->addMedia(storage_path('media/uploads/' . $request->input('media')))->toMediaCollection('avatar');
            $employee->media_id = $media->id;
            $employee->save();
        }

        return response()->json([
            'status' => true,
            'message' => $employee->employee_id . ' updated successfully.',
            'redirect_to' => route($this->folder . 'index'),
        ]);
    }
}
