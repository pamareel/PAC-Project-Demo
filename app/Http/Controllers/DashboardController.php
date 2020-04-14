<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

if (isset($_POST['submit'])) {
if(isset($_POST['radio']))
{
echo "<span>You have selected :<b> ".$_POST['radio']."</b></span>";
}
else{ echo "<span>Please choose any radio button.</span>";}
}

class DashboardController extends Controller
{
    function policy(){
        return view('Dashboard-GPU');
    }
    public function getTPUDashboard(){
        return view('Dashboard-TPU');
    }

    public function getGPUDashboard(){
        return view('Dashboard-GPU');
    }

    public function getTOP5GPU()
    {
        #import code in SQL server
        $data = DB::table('GPU61_Top5')->get();
        $bool = DB::select('EXEC findTop5GPU61');

        //$data3[] = $row;

        dump($data);
        //dump($data['BUDGET_YEAR']);
        //show data in website
        //$GPU1 = $data['GPU_NAME'];
        //$data['Total_Real_Amount'];
        //dump($GPU1);
        //foreach $data
        //$bool = arry($data->);
    }
}


