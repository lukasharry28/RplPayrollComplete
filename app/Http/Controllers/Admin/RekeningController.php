<?php

namespace App\Http\Controllers\Admin;

use App\Rekening, App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningRequest;

class RekeningController extends Controller
{
    private $folder = "admin.rekening.";

    public function index()
    {

        $get_data = route($this->folder.'getData');
        return View($this->folder.'index',[
            'get_data' => $get_data,
        ]);
    }

    public function getData()
    {

        $rekenings = Rekening::get();
        // dd($rekenings); // Debug untuk melihat isi data

        return View($this->folder.'content',[
            'rekenings'=>$rekenings,
            'add_new' => route($this->folder.'create'),
            'sum' => Rekening::sum('saldo'),
            'moveToTrashAllLink' => route($this->folder.'massDelete'),
        ]);
    }

    public function create()
    {
        return View($this->folder."create",[
            'form_store' => route($this->folder.'store'),
            ]);
    }

    public function store(RekeningRequest $request)
    {
        $rekening = Rekening::create($request->all());

        return response()->json([
            'status'=>true,
            'message'=>'New Rekening created successfully.',
            'redirect_to' => route($this->folder.'index')
            ]);
    }

    public function show(Rekening $rekening)
    {
        abort(404);
    }

    public function edit(Rekening $rekening)
    {
        $banks = Bank::all();

    	return View($this->folder.'edit',[
    		'rekening' => $rekening,
    		'form_update' => route($this->folder.'update',['rekening'=>$rekening]),
            'banks' => $banks,
    	]);
    }

    public function update(RekeningRequest $request, Rekening $rekening)
    {
        $rekening->update($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'Rekening '.$rekening->no_rekening.' updated successfully.',
            'redirect_to' => route($this->folder.'index')
            ]);
    }

    public function destroy(Rekening $rekening)
    {
        $rekening->delete();
        return response()->json([
                'status' => true,
                'message' => "Your Record has been Deleted!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
    }

    public function massDelete(Request $request)
    {
        $rekenings = Rekening::whereIn('id_rekening',$request->ids)
                        ->delete();

        return response()->json([
                'status' => true,
                'message' => "Your all Record has been Deleted!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
    }



}
