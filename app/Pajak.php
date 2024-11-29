<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    protected $primaryKey = 'pajak_id'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'pajak_id',
        'title',
        'tax_amount',
    ];

    protected $casts = [
        'tax_amount' => 'decimal:2'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function employees(){
        return $this->hasOne(Employee::class,'pajak_id','pajak_id');
    }
}
