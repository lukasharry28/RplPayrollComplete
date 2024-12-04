<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Employee extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'employee_id',
        'nik',
        'first_name',
        'last_name',
        'gender',
        'tgl_lahir',
        'tmp_lahir',
        'agama',
        'gol_darah',
        'status_nikah',
        'phone',
        'email',
        'address',
        'remark',
        'id_rekening',
        'status_kerja',
        'position_id',
        'schedule_id',
        'media_id',
        // 'rate_per_hour',
        'salary',
        'tunjangan_id',
        'pajak_id',
        'deduction_id',
        'is_active',
    ];

    protected $hidden = [
        'avatarMedia',
    ];

    protected $appends = [
        'media_url','created_on','total_working_hour','gross_amount'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getRouteKeyName()
    {
        return 'employee_id';
    }

    public function setFirstNameAttribute($value){
        $this->attributes['first_name'] = ucwords($value);
    }

    public function setLastNameAttribute($value){
        $this->attributes['last_name'] = ucwords($value);
    }

    protected static function boot()
    {
    	parent::boot();
    	static::creating(function($employee){
    		$employee->employee_id = strtoupper(uniqid("EMP"));
    	});
    }

    public function registerMediaCollections(){
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function(Media $media){
                $this->addMediaConversion('thumb')
                ->format('png')
                ->width(128)
                ->height(128);
            });
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }


    public function attendances(){
        return $this->hasMany(Attendance::class,'employee_id','id');
    }

    // public function cashAdvances(){
    //     return $this->hasMany(CashAdvance::class,'employee_id','id');
    // }

    public function tunjangan(){
        return $this->hasOne(Tunjangan::class,'tunjangan_id','tunjangan_id');
    }

    public function pajak(){
        return $this->hasOne(Pajak::class,'pajak_id','pajak_id');
    }

    public function deduction(){
        return $this->hasOne(Deduction::class,'deduction_id','deduction_id');
    }


    // public function overtime(){
    //     return $this->hasOne(Pajak::class,'overtime_id','overtime_id');
    // }

    public function rekening(){
        return $this->hasOne(Rekening::class,'id_rekening','id_rekening');
    }


    public function payroll(){
        return $this->hasMany(Payroll::class,'employee_id','id');
    }

    // public function getTotalWorkingHourAttribute(){
    //     return $this->attendances->sum('num_hour');
    // }

    // public function getGrossAmountAttribute(){
    //     return ($this->attendances->sum('num_hour') * $this->attributes['rate_per_hour'])/60;
    // }

    protected function avatarMedia(){
        return $this->hasOne(Media::class,'id','media_id');
    }

    public function getMediaUrlAttribute(){
        $avatar = strtolower($this->attributes['gender'].'.png');
        $url = [
            'original' => url('admin_assets/avatars/employee/'.$avatar),
            'thumb' => url('admin_assets/avatars/employee/thumb/'.$avatar),
        ];
        if(!is_null($this->attributes['media_id']) && !is_null($this->avatarMedia)){
            $imgurl = $this->avatarMedia->getFullUrl();
            // $imgHeaders = @get_headers( str_replace(" ", "%20", $imgurl) )[0];
            // if(file_exists($this->avatarMedia->getPath()) && ($imgHeaders != 'HTTP/1.1 404 Not Found')){
                $url = [
                    'original' => $this->avatarMedia->getFullUrl(),
                    'thumb' => $this->avatarMedia->getFullUrl('thumb'),
                ];
            // }
        }
        return $url;
    }

    public function getCreatedOnAttribute(){
        $dt = $this->attributes['created_at'];
        $date = date('M d, Y', strtotime($dt));
        return $date;
    }
}
