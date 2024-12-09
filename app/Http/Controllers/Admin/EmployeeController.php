<?php

namespace App\Http\Controllers\Admin;

use App\{Employee, Schedule, Position, Tunjangan, Rekening, Pajak, Deduction};
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
        $employees = Employee::with(['position', 'schedule', 'deduction', 'pajak', 'tunjangan', 'rekening'])->get();

        return DataTables::of($employees)
            ->addIndexColumn()
            ->addColumn('avatar', function ($data) {
                return "<img src='" . $data->media_url['thumb'] . "' alt='Avatar' class='table-user-thumb'>";
            })
            ->addColumn('first_name', function ($data) {
                return $data->first_name;
            })
            ->addColumn('last_name', function ($data) {
                return $data->last_name;
            })
            ->addColumn('biodata', function ($data) {
                return "<div>
                            <b>Gender:</b> <span>{$data->gender}</span><br>
                            <b>Agama:</b> <span>{$data->agama}</span><br>
                            <b>Golongan Darah:</b> <span>{$data->gol_darah}</span><br>
                            <b>Tanggal Lahir:</b> <span>{$data->tgl_lahir}</span><br>
                            <b>Tempat Lahir:</b> <span>{$data->tmp_lahir}</span><br>
                            <b>Status Menikah:</b> <span>{$data->status_nikah}</span><br>
                        </div>";
            })
            ->addColumn('kontak', function ($data) {
                return "<div>
                            <b>Phone:</b> <span>{$data->phone}</span><br>
                            <b>Email:</b> <span>{$data->email}</span><br>
                            <b>No Rekening:</b> <span>{$data->rekening->no_rekening}</span><br>
                            <b>Bank:</b> <span>{$data->rekening->bank->bank_name}</span><br>
                        </div>";
            })
            ->addColumn('position', function ($data) {
                return $data->position->title ?? '-';
            })
            ->addColumn('details', function ($data) {
                return "<div>
                            <b>Employee Id:</b> <span>{$data->employee_id}</span><br>
                            <b>Status Kerja:</b> <span>{$data->status_kerja}</span><br>
                            <b>Schedule:</b> <span>{$data->schedule->time_in} - {$data->schedule->time_out}</span><br>
                            <b>Address:</b> <span>{$data->address}</span><br>
                        </div>";
            })
            ->addColumn('is_active', function ($data) {
                return $data->is_active
                    ? "<span class='success-dot' title='Active Employee'></span>"
                    : "<i class='ik ik-alert-circle text-danger' title='Inactive Employee'></i>";
            })
            ->addColumn('action', function ($data) {
                $btn = "<div class='table-actions'>
                            <a data-href='" . route($this->folder . 'show', ['employee_id' => $data->employee_id]) . "' class='show-employee cursor-pointer'><i class='ik ik-eye text-primary'></i></a>
                            <a href='" . route($this->folder . "edit", ['employee_id' => $data->employee_id]) . "'><i class='ik ik-edit-2 text-dark'></i></a>
                            <a data-href='" . route($this->folder . "destroy", ['id' => $data->id]) . "' class='delete cursor-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
                        </div>";
                return $btn;
            })
            ->rawColumns(['avatar', 'biodata', 'details', 'is_active', 'action', 'select'])
            ->toJson();
    }

    public function show(Employee $employee, Deduction $deduction, Pajak $pajak, Tunjangan $tunjangan, Rekening $rekening){
        return View($this->folder.'show',[
            'employee'=>$employee, 'pajak' => $pajak, 'tunjangan' => $tunjangan, 'deduction' => $deduction, 'rekening' => $rekening,
        ]);
    }

    public function create()
    {
        return view($this->folder . "create", [
            'form_store' => route($this->folder . 'store'),
            'schedules' => Schedule::get(),
            'positions' => Position::get(),
            'rekenings' => Rekening::get(),
            'tunjangans' => Tunjangan::get(),
            'pajaks' => Pajak::get(),
            'deductions' => Deduction::get(),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->only([
            'nik', 'first_name', 'last_name', 'gender', 'tgl_lahir', 'tmp_lahir',
            'agama', 'gol_darah', 'status_nikah', 'phone', 'email',
            'address', 'remark', 'schedule_id', 'status_kerja', 'position_id',
            'salary', 'is_active', 'tunjangan_id', 'pajak_id', 'deduction_id', 'id_rekening'
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
            'rekenings' => Rekening::get(),
            'tunjangans' => Tunjangan::get(),
            'pajaks' => Pajak::get(),
            'deductions' => Deduction::get(),
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
            'address', 'remark', 'schedule_id', 'status_kerja', 'position_id',
            'salary', 'is_active', 'tunjangan_id', 'pajak_id', 'deduction_id', 'id_rekening'
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

    protected function permanentDelete($id){
        $trash = Employee::find($id);
        if (count($trash->getMedia('avatar')) > 0) {
            foreach ($trash->getMedia('avatar') as $media) {
                $media->delete();
            }
        }
        $trash->delete();
        return true;
    }

    protected function massPermanentDelete($ids){
        $employees = Employee::whereIn('id',$ids)
                        ->get();
        foreach ($employees as $employee) {
            $this->permanentDelete($employee->id);
        }
        return true;
    }

    public function destroy(Request $request,$id)
    {
        $trash = $this->permanentDelete($id);
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
        //this is for permanent delete all record
        $trash = $this->massPermanentDelete($request->ids);

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
