<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::group( ['middleware' => 'auth'], function()
{
    Route::group(['middleware' => ['admin']], function () {
        
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');


    //acounts
     Route::get('users','UserController@users');
     Route::post('new-account','UserController@new_account');
     Route::post('delete-account','UserController@delete_account');
     Route::post('change-password/{id}','UserController@changepassword');

     Route::post('deactivate-user','UserController@deactivate_user');
     Route::post('activate-user','UserController@activate_user');
     Route::post('edit-user/{id}','UserController@edit_user');

     //companies
     Route::get('companies','CompanyController@company');
     Route::post('new-company','CompanyController@new_company');
     Route::post('deactivate-company','CompanyController@deactivate_company');
     Route::post('activate-company','CompanyController@activate_company');
     Route::post('edit-company/{id}','CompanyController@edit_company');

     //Brand
     Route::get('brands','BrandController@brands');
     Route::post('deactivate-brand','BrandController@deactivate_brand');
     Route::post('activate-brand','BrandController@activate_brand');
     Route::post('new-brand','BrandController@new_brand');
     Route::post('edit-brand/{id}','BrandController@edit_brand');

     //Class
     Route::get('class-equipment','ClassController@class_equipment');
     Route::post('new-class','ClassController@new_class');
     Route::post('deactivate-class','ClassController@deactivate_class');
     Route::post('activate-class','ClassController@activate_class');
     Route::post('edit-class/{id}','ClassController@edit_class');

     //Category
     Route::post('new-category','CategoryController@new_category');
     Route::post('deactivate-category','CategoryController@deactivate_category');
     Route::post('activate-category','CategoryController@activate_category');
     Route::post('edit-category/{id}','CategoryController@edit_category');

     //Insurance
     Route::post('new-insurance','InsuranceController@new_insurance');
     Route::post('deactivate-insurance','InsuranceController@deactivate_insurance');
     Route::post('activate-insurance','InsuranceController@activate_insurance');
     Route::post('edit-insurance/{id}','InsuranceController@edit_insurance');

     //Equipments
     Route::get('equipments','EquipmentController@equipments');
     Route::post('new-equipment','EquipmentController@new_equipment');
     Route::get('maintenance','EquipmentController@maintenance');

     //Vessels
     Route::get('vessels','VesselController@vessels');
     Route::post('new-vessel','VesselController@newVessel');
     
    });
     //Request
     Route::post('change-pass','UserController@changepass');
     Route::get('requests','RequestController@requests');
     Route::post('new-request','RequestController@new_request');
     Route::post('cancel-request','RequestController@cancel_request');
     Route::post('edit-request/{id}','RequestController@edit_request');
     

     //For Approval
     Route::get('for-approval','RequestController@for_approval');
     Route::post('approve-request','RequestController@approve_request');
     Route::post('decline-request','RequestController@declined_request');
     Route::post('decline-request-dispatch','RequestController@declined_request_dispatch');
     Route::get('all-approved-requests','RequestController@all_approved_requests');
     Route::get('all-declined-requests','RequestController@all_declined_requests');

     //For Dispatch
     Route::get('for-dispatch','RequestController@for_dispatch');
     Route::post('distpach-equipment','RequestController@dispatch_equip');
     Route::get('dispatch-approval','RequestController@dispatch_approval');
     Route::post('approve-dispatch','RequestController@approved_dispatch');
     Route::get('dispatch-equipments','RequestController@dispatch_equipments');
     Route::get('appproved-dispatch-requests','RequestController@appproved_dispatch_requests');


     //Projects
     Route::get('project','ProjectController@project');
     Route::post('new-project','ProjectController@new_project');
     Route::post('deactivate-project','ProjectController@deactivate_project');
     Route::post('activate-project','ProjectController@activate_project');
     Route::post('edit-project/{id}','ProjectController@edit_project');
     
     //Fuels
     Route::get('fuels','FuelController@view_fuel');
     Route::get('fuel-monitoring','FuelController@fuel_report');
     Route::post('new-fuel','FuelController@new_fuel');
     Route::get('fuel-monitoring-export','FuelController@export_report');
     Route::get('fuel-export','FuelController@export');
     Route::get('receivings','FuelController@receivings');
     Route::post('new-receiving','FuelController@new_received');
     Route::get('fuels-report','FuelController@fuels_report');
     Route::get('transfer','FuelController@transfer');
     Route::post('tansfer-data','FuelController@transfertransaction');
     Route::get('edit-fuel','FuelController@editFuels');

    

     //Locations
     route::get('locations','LocationController@locations');

});

//API  
Route::get('companies-api','CompanyController@companiesAPI');
Route::get('departments-api','DepartmentController@departmentsAPI');
    


