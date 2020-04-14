<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    function policy(){
        return view('Dashboard');
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


