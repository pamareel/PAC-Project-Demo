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
        // $annualSpendingChart->minimalist(true);
        $annualSpendingChart->labels([$y1, $y2, $y3, $y4, $y5]);
        $annualSpendingChart->dataset('Annual Spending', 'line', [$s1, $s2, $s3, $s4, $s5])->color($borderColors);
        // $annualSpendingChart->dataset('Annual Spending (invert)', 'line', [$t1, $t2, $t3, $t4, $t5]);
            // ->backgroundcolor($fillColors);

        //cost saving table
        [$cs_table_GPU, $totalPotentialSave_GPU] = $this->table_GPU_cost_saving('GPU','2562');
        [$cs_table_TPU, $totalPotentialSave_TPU] = $this->table_TPU_cost_saving('TPU','2562');

        $send_data = array(
            'annualSpendingChart' => $annualSpendingChart,
            'y1' => $y1,
            'y2' => $y2,
            'y3' => $y3,
            'y4' => $y4,
            'y5' => $y5,
            's1' => $s1,
            's2' => $s2,
            's3' => $s3,
            's4' => $s4,
            's5' => $s5,
            'cs_table_GPU'=>$cs_table_GPU,
            'totalPotentialSave_GPU'=>$totalPotentialSave_GPU,
            'cs_table_TPU'=>$cs_table_TPU,
            'totalPotentialSave_TPU'=>$totalPotentialSave_TPU
        );
        if($TGX == "TPU"){
            return view('Dashboard-TPU', $send_data );
        }else{
            return view('Dashboard-GPU', $send_data );
        }
    }

    public function table_GPU_cost_saving($TGX,$year){
        $query_gpu = "SELECT GPU_ID, GPU_NAME, FORMAT(Count_TPU, N'N0') as Count_TPU, Real_Total_Spend as Real_Real_Total_Spend, FORMAT(Real_Total_Spend, N'N0') as Real_Total_Spend, Potential_Saving_Cost as Poten_Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N0') as Potential_Saving_Cost, Percent_saving as PS_Percent_saving, cast(Percent_saving as decimal(10,2)) as Percent_saving ";
        $query_gpu .= "FROM CostSaving_GPU where BUDGET_YEAR = '".$year."' order by PS_Percent_saving DESC;";
        $GPU_result = DB::select($query_gpu);
        
        $content = '';

        for ($i = 0; $i < Count($GPU_result) ; $i++) {

            $Potential_Saving_Cost = $GPU_result[$i]->Potential_Saving_Cost;
            $Percent_saving = $GPU_result[$i]->Percent_saving;
            if($GPU_result[$i]->Poten_Potential_Saving_Cost < 0 && $GPU_result[$i]->PS_Percent_saving <0){
                $Potential_Saving_Cost = '-';
                $Percent_saving = '-';
            }

            $content .= '<tr>';
            $content .= '<td style="text-align:left;">'.$GPU_result[$i]->GPU_ID.'</td>';
            $content .= '<td style="text-align:left;">'.$GPU_result[$i]->GPU_NAME.'</td>';
            $content .= '<td style="text-align:center;">'.$GPU_result[$i]->Count_TPU.'</td>';
            $content .= '<td style="text-align:right; padding-right:12px;">'.$GPU_result[$i]->Real_Total_Spend.'</td>';
            $content .= '<td style="text-align:right; padding-right:15px;">'.$Potential_Saving_Cost.'</td>';
            $content .= '<td style="text-align:center;">'.$Percent_saving .'</td>';
            $content .= '</tr>';
        }

        $totalPotentialSave_query = "SELECT FORMAT(sum(Potential_Saving_Cost), N'N0') as sc ";
        $totalPotentialSave_query .= "FROM CostSaving_GPU where BUDGET_YEAR = '".$year."' and Potential_Saving_Cost >=0;";
        $totalPotentialSave_result = DB::select($totalPotentialSave_query);
        $totalPotentialSave = $totalPotentialSave_result[0]->sc;
       
        return [$content, $totalPotentialSave];
    }

    public function table_TPU_cost_saving($TGX,$year){
        $query_tpu = "SELECT GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, Real_Total_Spend as Real_Real_Total_Spend, FORMAT(Real_Total_Spend, N'N0') as Real_Total_Spend, Potential_Saving_Cost as Poten_Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N0') as Potential_Saving_Cost, Percent_saving as PS_Percent_saving, cast(Percent_saving as decimal(10,2)) as Percent_saving ";
        $query_tpu .= "FROM CostSaving_TPU where BUDGET_YEAR = '".$year."' order by PS_Percent_saving DESC;";
        $TPU_result = DB::select($query_tpu);
        
        $content = '';

        for ($i = 0; $i < Count($TPU_result) ; $i++) {

            $Potential_Saving_Cost = $TPU_result[$i]->Potential_Saving_Cost;
            $Percent_saving = $TPU_result[$i]->Percent_saving;
            if($TPU_result[$i]->Poten_Potential_Saving_Cost < 0 && $TPU_result[$i]->PS_Percent_saving <0){
                $Potential_Saving_Cost = '-';
                $Percent_saving = '-';
            }

            $content .= '<tr>';
            $content .= '<td style="text-align:left;">'.$TPU_result[$i]->GPU_ID.'</td>';
            $content .= '<td style="text-align:left;">'.$TPU_result[$i]->GPU_NAME.'</td>';
            $content .= '<td style="text-align:left;">'.$TPU_result[$i]->TPU_ID.'</td>';
            $content .= '<td style="text-align:left;">'.$TPU_result[$i]->TPU_NAME.'</td>';
            $content .= '<td style="text-align:right; padding-right:12px;">'.$TPU_result[$i]->Real_Total_Spend.'</td>';
            $content .= '<td style="text-align:right; padding-right:15px;">'.$Potential_Saving_Cost.'</td>';
            $content .= '<td style="text-align:center;">'.$Percent_saving .'</td>';
            $content .= '</tr>';
        }

        $totalPotentialSave_query = "SELECT FORMAT(sum(Potential_Saving_Cost), N'N0') as sc ";
        $totalPotentialSave_query .= "FROM CostSaving_TPU where BUDGET_YEAR = '".$year."' and Potential_Saving_Cost >=0;";
        $totalPotentialSave_result = DB::select($totalPotentialSave_query);
        $totalPotentialSave = $totalPotentialSave_result[0]->sc;
       
        return [$content, $totalPotentialSave];
    }

    public function getTOP5GPU()
    {
        #import code in SQL server
        $data = DB::table('GPU61_Top5')->get();
        $bool = DB::select('EXEC findTop5GPU61');
        dump($data);
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


