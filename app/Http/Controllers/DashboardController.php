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
        $totalSpend = DB::select('select TOP 5 BUDGET_YEAR, sum(CAST(Real_Amount as float) * CAST(Real_Unit_Price as float)) as total from drugs
                                    group by BUDGET_YEAR ORDER by BUDGET_YEAR Desc;');
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
        // $t1 = $totalSpend[0]->total;
        // $t2 = $totalSpend[1]->total;
        // $t3 = $totalSpend[2]->total;
        // $t4 = $totalSpend[3]->total;
        // $t5 = $totalSpend[4]->total;
        // $annualSpendingChart = new UserChart;
        // $annualSpendingChart->labels([$y1, $y2, $y3, $y4, $y5]);
        // $annualSpendingChart->dataset('Annaul Spending', 'line', [$s1, $s2, $s3, $s4, $s5]);
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
        $annualSpendingChart = new UserChart;
        $correlation = new UserChart;
        // $annualSpendingChart->minimalist(true);
        $annualSpendingChart->labels([$y1, $y2, $y3, $y4, $y5]);
        $annualSpendingChart->dataset('Annual Spending', 'line', [$s1, $s2, $s3, $s4, $s5])->color($borderColors);
        // $annualSpendingChart->dataset('Annual Spending (invert)', 'line', [$t1, $t2, $t3, $t4, $t5]);
        $x = array("30", "6", "23");
        $y = array("45", "2", "9");
        $corr = $this->Corr($x,$y);
            // ->backgroundcolor($fillColors);

        $send_data = array(
            'annualSpendingChart' => $annualSpendingChart,
            'corr' => $corr,
            'y1' => $y1,
            'y2' => $y2,
            'y3' => $y3,
            'y4' => $y4,
            'y5' => $y5,
            's1' => $s1,
            's2' => $s2,
            's3' => $s3,
            's4' => $s4,
            's5' => $s5
        );
        if($TGX == "TPU"){
            return view('Dashboard-TPU', $send_data );
        }else{
            return view('Dashboard-GPU', $send_data );
        }
    }

    public function Corr($x, $y){

        $length= count($x);
        $mean1=array_sum($x) / $length;
        $mean2=array_sum($y) / $length;
        
        $a=0;
        $b=0;
        $axb=0;
        $a2=0;
        $b2=0;
        
        for($i=0;$i<$length;$i++)
        {
        $a=$x[$i]-$mean1;
        $b=$y[$i]-$mean2;
        $axb=$axb+($a*$b);
        $a2=$a2+ pow($a,2);
        $b2=$b2+ pow($b,2);
        }
        
        $corr= $axb / sqrt($a2*$b2);
        
        return $corr;
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

    #not used
    public function createChart(){
        $chartline = Charts::new('line', 'Frappe')
            ->setTitle("Line Chart")
            ->setLabels([61,62,63])
            ->setValues([10,20,30])
            ->setElementLabel("LabelElement");
        return view('Dashboard-TPU', ['chartline' => $chartline]);
    }
}


