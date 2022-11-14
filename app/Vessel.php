<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    //
    public function type_info()
    {
        return $this->belongsTo(VesselType::class,"type","id");
    }
    public function contract()
    {
        return $this->hasMany(VesselContract::class);
    }
}
