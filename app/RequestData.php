<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestData extends Model
{
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function approver()
    {
        return $this->belongsTo(User::class,'approver_id','id');
    }
    public function approve_by()
    {
        return $this->belongsTo(User::class,'approver_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function class()
    {
        return $this->belongsTo(ClassEquipment::class,'class_id','id');
    }
    public  function histories()
    {
        return $this->hasMany(RequestHistory::class,'request_data_id','id')->orderBy('id','desc');
    }
    public  function project()
    {
        return $this->belongsTo(Project::class);
    }
    public  function deploy()
    {
        return $this->hasOne(RequestDeployment::class,'request_id','id');
    }
}
