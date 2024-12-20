<?php

namespace App\Providers;

use App\Payroll;
use App\Observers\PayrollObserver;
use Illuminate\Support\ServiceProvider;

class PayrollProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Payroll::observe(PayrollObserver::class);
    }
}
