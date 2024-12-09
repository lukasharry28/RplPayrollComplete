<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $primaryKey = 'id_rekening'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'id_rekening',
        'no_rekening',
        'nama_pemilik',
        'rekening_name',
        'type_rekening',
        'saldo',
        'bank_id'
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    

    public function employees(){
        return $this->hasMany(Employee::class,'id_rekening','id_rekening');
    }

    public function company(){
        return $this->hasMany(Company::class,'id_rekening','id_rekening');
    }

    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id');
    }


    public function debit($amount)
    {
        if ($this->saldo < $amount) {
            throw new \Exception('Saldo tidak mencukupi');
        }
        $this->saldo -= $amount;
        $this->save();
    }

    public function credit($amount)
    {
        $this->saldo += $amount;
        $this->save();
    }

    public function getMediaUrlAttribute()
    {
        $avatar = strtolower($this->attributes['image_name'] . '.png');
        $url = [
            'thumb' => url('admin_assets/avatars/bank/' . $avatar),
            'original' => url('admin_assets/avatars/bank/' . $avatar),
        ];
        return $url;
    }


}
