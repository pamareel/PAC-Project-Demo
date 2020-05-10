<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HospitalDashboardController extends Controller
{
    public function index($Hname){
        
        $sendData = array(
            'Hname'=>$Hname);
        return view('HospitalDashboardPage', $sendData );
    }
}
