<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'num_hour',
        'ontime_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'date',
    ];

    protected $appends = ['whr'];

    public function getDateAttribute(){
        return date("M d, Y",strtotime($this->attributes['date']));
    }

    public function setDateAttribute($value){
        $this->attributes['date'] = date("Y-m-d",strtotime($value));
    }

    public function getTimeInAttribute(){
        return date('h:i A', strtotime($this->attributes['time_in']));
    }

    public function getTimeOutAttribute(){
        return date('h:i A', strtotime($this->attributes['time_out']));
    }

    public function getWhrAttribute(){
        return hoursandmins($this->attributes['num_hour'])."/hr";
    }

    public function setTimeInAttribute($value){
        $this->attributes['time_in'] = date('H:i:s', strtotime($value));
    }

    public function setTimeOutAttribute($value){
        $this->attributes['time_out'] = date('H:i:s', strtotime($value));
    }

    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    public function getTotalHoursAttribute()
    {
        $start = strtotime($this->time_in);
        $end = strtotime($this->time_out);
        return round(($end - $start) / 3600, 2);
    }

    public function isOvertime()
    {
        return $this->num_hour > 8;
    }

}
