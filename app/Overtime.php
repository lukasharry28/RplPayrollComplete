<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Overtime extends Model
{
    use HasSlug;

    protected $primaryKey = 'overtime_id'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'overtime_id',
        'title',
        'slug',
        'description',
        'rate_amount_hours',
        'employee_id',
        'date',
        'total_amount'
    ];

    protected $casts = [
        'rate_amount_hourse' => 'decimal',
        'total_amount' => 'decimal'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'date',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function setTitleAttribute($value){
        $this->attributes['title'] = ucwords($value);
    }

    public function getDateAttribute(){
        return date("M d, Y",strtotime($this->attributes['date']));
    }

    public function setDateAttribute($value){
        $this->attributes['date'] = date("Y-m-d",strtotime($value));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function employee(){
        return $this->hasOne(Employee::class,'employee_id','employee_id');
    }

    public function payroll(){
        return $this->hasMany(Payroll::class,'overtime_id','overtime_id');
    }

    public static function boot()
    {
        parent::boot();

        // Setiap kali menyimpan data Overtime, kita akan hitung total_amount
        static::saving(function($overtime) {
            $overtime->calculateTotalAmount();
        });
    }

    // Menambahkan fungsi untuk menghitung total_amount
    public function calculateTotalAmount()
{
    $employee = $this->employee; // Ambil data karyawan dari relasi

    if (!$employee) {
        // Handle the case when there is no associated employee
        return 0;  // or handle as needed
    }

    // Ensure attendances is not null and sum it
    $workHoursPerDay = $employee->attendances ? $employee->attendances->sum('num_hour') : 0;

    $workHoursNormal = 8;
    $ratePerHour = $this->rate_amount_hours ?? 0;

    $overtimeHours = ($workHoursPerDay > $workHoursNormal) ? $workHoursPerDay - $workHoursNormal : 0;

    $totalAmount = $overtimeHours * $ratePerHour;

    $this->total_amount = $totalAmount;

    return $totalAmount;
}

}
