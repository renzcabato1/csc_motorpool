<?php

namespace App\Http\Controllers;
use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //
    public function departmentsAPI()
    {
        $companies = Department::get();
     
        return $companies;
    }
}
