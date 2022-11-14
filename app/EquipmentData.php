<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentData extends Model
{
    //
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function class()
    {
        return $this->belongsTo(ClassEquipment::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function insurance()
    {
        return $this->belongsTo(InsuranceCompany::class,'insurance_company_id','id');
    }
    public function fuel()
    {
        return $this->hasMany(Fuel::class,'equipment_id','id')->orderBy('id','desc');
    }
}
