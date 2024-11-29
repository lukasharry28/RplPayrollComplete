<?php

namespace App\Http\Controllers\Admin;

use App\{Company, Rekening};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class CompanyController extends Controller
{
    private $folder = "admin.company.";

    public function index()
    {
        return view($this->folder.'index', [
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData()
    {
        return view($this->folder.'content', [
            'add_new' => route($this->folder.'create'),
            'getDataTable' => route($this->folder.'getDataTable'),
            'moveToTrashAllLink' => route($this->folder.'massDelete'),
            'companies' => Company::all(),
        ]);
    }

    public function getDataTable()
    {
        $companies = Company::with('rekening')->get();

        return DataTables::of($companies)
            ->addIndexColumn()
            ->addColumn('rekening', function ($data) {
                return $data->rekening ? $data->rekening->bank_name : '-';
            })
            ->addColumn('action', function ($data) {
                $btn = "<div class='table-actions'>
                    <a href='".route($this->folder.'show', ['company_id' => $data->company_id])."'><i class='ik ik-eye text-primary'></i></a>
                    <a href='".route($this->folder.'edit', ['company_id' => $data->company_id])."'><i class='ik ik-edit-2 text-dark'></i></a>
                    <a data-href='".route($this->folder.'destroy', ['id' => $data->company_id])."' class='delete cursor-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
                </div>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        $rekenings = Rekening::all();

        return view($this->folder.'create', [
            'form_store' => route($this->folder.'store'),
            'rekenings' => $rekenings,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'id_rekening' => 'nullable|exists:rekenings,id_rekening',
        ]);

        Company::create($data);

        return response()->json([
            'status' => true,
            'message' => 'New Company created successfully.',
            'redirect_to' => route($this->folder.'index'),
        ]);
    }

    public function show(Company $company)
    {
        return view($this->folder.'show', [
            'company' => $company,
        ]);
    }

    public function edit(Company $company)
    {
        $rekenings = Rekening::all();

        return view($this->folder.'edit', [
            'company' => $company,
            'form_update' => route($this->folder.'update', ['company' => $company]),
            'rekenings' => $rekenings,
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'id_rekening' => 'nullable|exists:rekenings,id_rekening',
        ]);

        $company->update($data);

        return response()->json([
            'status' => true,
            'message' => $company->company_name.' updated successfully.',
            'redirect_to' => route($this->folder.'index'),
        ]);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'status' => true,
            'message' => 'Company deleted successfully.',
            'getDataUrl' => route($this->folder.'getData'),
        ]);
    }

    public function massDelete(Request $request)
    {
        $ids = $request->ids;
        Company::whereIn('company_id', $ids)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Selected Companies deleted successfully.',
            'getDataUrl' => route($this->folder.'getData'),
        ]);
    }
}
