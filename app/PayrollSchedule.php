<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollSchedule extends Model
{
    protected $table = 'payrollschedules';
    protected $primaryKey = 'payschedule_id'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'payschedule_id',
        'company_id',
        'payroll_date',
        'payroll_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'payroll_date',
    ];

    public function payroll(){
        return $this->hasMany(Payroll::class,'payschedule_id','payschedule_id');
    }

    public function company(){
        return $this->hasOne(Company::class,'company_id','company_id');
    }

}
