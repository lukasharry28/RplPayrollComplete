<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $primaryKey = 'bank_id'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'bank_id',
        'bank_name',
        'image_name',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function employees(){
        return $this->hasMany(Employee::class,'bank_id','bank_id');
    }

    public function company(){
        return $this->hasMany(Company::class,'bank_id','bank_id');
    }
}
