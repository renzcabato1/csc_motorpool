<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestDeployment extends Model
{
    //
    public  function equipment_data()
    {
        return $this->hasOne(EquipmentData::class,'id','equipment_datas_id');
    }
}
