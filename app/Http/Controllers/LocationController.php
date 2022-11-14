<?php

namespace App\Http\Controllers;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public function locations()
    {

        $locations = Location::get();
        return view('locations',
        array(
            'subheader' => '',
            'header' => "Locations",
            'locations' => $locations,
        ));
    }
}
