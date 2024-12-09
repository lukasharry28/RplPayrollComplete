<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companys';
    protected $primaryKey = 'company_id'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'company_id',
        'company_name',
        'phone',
        'email',
        'address',
        'id_rekening'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function payroll(){
        return $this->hasMany(Payroll::class,'company_id','company_id');
    }

    public function rekening(){
        return $this->hasOne(Rekening::class,'id_rekening','id_rekening');
    }

}
