<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    public function equipment()
    {
        return $this->hasMany(EquipmentData::class,"company_id","id");
    }
}
