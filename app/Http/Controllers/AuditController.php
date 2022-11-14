<?php

namespace App\Http\Controllers;
use App\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    //

    public function audit_register($id,$table_name,$new_data,$previous_data,$action)
    {

        $audit_log = new AuditLog;
        $audit_log->user_id = auth()->user()->id;
        $audit_log->table_name = $table_name;
        $audit_log->table_id = $id;
        $audit_log->previous_data = $previous_data;
        $audit_log->after_data = $new_data;
        $audit_log->action = $action;
        $audit_log->save();

    }
}
