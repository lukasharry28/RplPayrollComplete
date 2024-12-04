<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Deduction,Position, Company, Rekening, Bank, Tunjangan, Pajak, Schedule};
use Response;

class DashboardController extends Controller
{
    private $folder = "admin.";

    public function dashboard()
{
    $company = Company::first(); // Atau gunakan metode lain untuk memilih perusahaan yang relevan
    $saldo_rekening = $company ? $company->rekening->saldo : 0; // Sesuaikan dengan nama kolom di tabel

    return View($this->folder . "dashboard.dashboard", [
        'deductions' => Deduction::latest('deduction_id')->get(),
        'total_deduction' => Deduction::sum('amount'),
        'positions' => Position::inRandomOrder()->get(),
        'saldo_rekening' => $saldo_rekening,
    ]);
}


}
