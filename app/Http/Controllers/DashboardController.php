<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Charts\UserChart;

// if (isset($_POST['submit'])) {
// if(isset($_POST['radio']))
// {
// echo "<span>You have selected :<b> ".$_POST['radio']."</b></span>";
// }
// else{ echo "<span>Please choose any radio button.</span>";}
// }

class DashboardController extends Controller
{
    function policy(){
        return view('Dashboard-GPU');
    }
    public function index($TGX){
        // total spending line graph
        $totalSpend = DB::select('EXEC findTotalSpend5years');
        $y1 = $totalSpend[4]->BUDGET_YEAR;
        $y2 = $totalSpend[3]->BUDGET_YEAR;
        $y3 = $totalSpend[2]->BUDGET_YEAR;
        $y4 = $totalSpend[1]->BUDGET_YEAR;
        $y5 = $totalSpend[0]->BUDGET_YEAR;
        $s1 = $totalSpend[4]->total;
        $s2 = $totalSpend[3]->total;
        $s3 = $totalSpend[2]->total;
        $s4 = $totalSpend[1]->total;
        $s5 = $totalSpend[0]->total;

        // $usersChart = new UserChart;
        // $usersChart->labels([$y1, $y2, $y3, $y4, $y5]);
        // $usersChart->dataset('Annaul Spending', 'line', [$s1, $s2, $s3, $s4, $s5]);
        // End total spending line graph
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)"

        ];
        $usersChart = new UserChart;
        // $usersChart->minimalist(true);
        $usersChart->labels([$y1, $y2, $y3, $y4, $y5]);
        $usersChart->dataset('Annual Spending', 'line', [$s1, $s2, $s3, $s4, $s5])
            ->color($borderColors);
            // ->backgroundcolor($fillColors);
        if($TGX == "TPU"){
            return view('Dashboard-TPU', [ 'usersChart' => $usersChart ] );
        }else{
            return view('Dashboard-GPU', [ 'usersChart' => $usersChart ] );
        }
        
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

    public function createChart(){
        $chartline = Charts::new('line', 'Frappe')
            ->setTitle("Line Chart")
            ->setLabels([61,62,63])
            ->setValues([10,20,30])
            ->setElementLabel("LabelElement");
        return view('Dashboard-TPU', ['chartline' => $chartline]);
    }
}


