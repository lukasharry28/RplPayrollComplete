<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    private $folder = "admin.user.";

    public function index()
    {
        $get_data = route($this->folder.'getData');
        return View($this->folder.'index',[
            'get_data' => $get_data,
        ]);
    }

    public function getData()
    {
        $admins = Admin::get();
        return View($this->folder.'content',[
            'admins'=>$admins,
            'add_new' => route($this->folder.'create'),
            'moveToTrashAllLink' => route($this->folder.'massDelete'),
        ]);
    }

    public function create()
    {
        return View($this->folder."create",[
            'form_store' => route($this->folder.'store'),
            ]);
    }

    public function store(AdminRequest $request)
    {
        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin = Admin::create($data);

        return response()->json([
            'status' => true,
            'message' => 'New Admin created successfully.',
            'redirect_to' => route($this->folder.'index'),
        ]);
    }


    public function show(Admin $admin)
    {
        abort(404);
    }

    public function edit(Admin $admin)
    {
    	return View($this->folder.'edit',[
    		'admin' => $admin,
    		'form_update' => route($this->folder.'update',['admin'=>$admin]),
    	]);
    }

    public function update(AdminRequest $request, Admin $admin)
    {
        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Admin '.$admin->username.' updated successfully.',
            'redirect_to' => route($this->folder.'index'),
        ]);
    }


    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->json([
                'status' => true,
                'message' => "Your Record has been Deleted!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
    }

    public function massDelete(Request $request)
    {
        $admins = Admin::whereIn('id',$request->ids)
                        ->delete();

        return response()->json([
                'status' => true,
                'message' => "Your all Record has been Deleted!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
    }
}
