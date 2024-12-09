<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Company;
use App\Rekening;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{

    private $module = "admin.company.";

    public function index(){
        // Load the 'bank' relationship with the 'rekening' relationship on the 'Company' model
        $company = Company::with(['rekening.bank'])->first();
        $rekenings = Rekening::with(['bank'])->where('type_rekening', 'rekening perusahaan')->get();

        return View($this->module.'profile', [
            'company' => $company,
            'rekenings' => $rekenings,
            'form_url' => route($this->module."update")
        ]);
    }
}
