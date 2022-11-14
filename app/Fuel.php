<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    //
    public function equipment()
    {
        return $this->belongsTo(EquipmentData::class,'equipment_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function locations()
    {
        return $this->belongsTo(Location::class,'location','id');
    }
    public function company_details()
    {
        return $this->belongsTo(Company::class,'affiliates_id','id');
    }
    public function generator()
    {
        return $this->hasOne(Generator::class,'id','generator_id');
    }
}

