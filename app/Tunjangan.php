<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tunjangan extends Model
{
    protected $primaryKey = 'tunjangan_id'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'tunjangan_id',
        'title',
        'rate_amount',
    ];

    protected $casts = [
        'rate_amount' => 'decimal:2'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function employees(){
        return $this->hasOne(Employee::class,'tunjangan_id','tunjangan_id');
    }

}
