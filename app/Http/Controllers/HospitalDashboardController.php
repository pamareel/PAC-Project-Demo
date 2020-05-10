<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HospitalDashboardController extends Controller
{
    public function index($year, $Hid){

        [$Hname, $donut_hos_drug_GPU, $donut_hos_drug_TPU, $top5_GPU_name, $top5_GPU_amount, $top5_TPU_name, $top5_TPU_amount] = $this->Donut_Hospital($year,$Hid);
        $sendData = array(
            'Hname'=>$Hname,
            'donut_hos_drug_GPU'=>$donut_hos_drug_GPU,
            'donut_hos_drug_TPU'=>$donut_hos_drug_TPU,
            'top5_GPU_name'=>$top5_GPU_name, 'top5_GPU_amount'=>$top5_GPU_amount,
            'top5_TPU_name'=>$top5_TPU_name, 'top5_TPU_amount'=>$top5_TPU_amount
        );
        return view('HospitalDashboardPage', $sendData );
    }

    function Donut_Hospital($year,$Hid){
        // $query_rd = "SELECT DEPT_ID, DEPT_NAME, ServicePlanType, PROVINCE_EN, Region, FORMAT(IP, N'N0') as IP, FORMAT(OP, N'N0') as OP, ";
        // $query_rd .= "CONVERT(varchar, CAST(Total_Spend as money), 1) as Total_Spend FROM Hos_detail ";
        // $query_rd .= "where BUDGET_YEAR = '".$year."' and DEPT_ID ='".$Hid."';";

        $query_gpu = "SELECT DEPT_ID, DEPT_NAME, GPU_ID, GPU_NAME, cast(wavg_unit_price as decimal(18,3)) as wavg_unit_price, Total_Amount as Total_Total_Amount, FORMAT(Total_Amount, N'N0') as Total_Amount ";
        $query_gpu .= "FROM PAC_hos_GPU where BUDGET_YEAR = '2562' and DEPT_ID = '".$Hid."' order by Total_Total_Amount DESC;";
        $GPU_result = DB::select($query_gpu);
        $Hname = $GPU_result[0]->DEPT_NAME;

        $query_tpu = "SELECT DEPT_ID, DEPT_NAME, TPU_ID, TPU_NAME, cast(wavg_unit_price as decimal(18,3)) as wavg_unit_price, Total_Amount as Total_Total_Amount, FORMAT(Total_Amount, N'N0') as Total_Amount ";
        $query_tpu .= "FROM PAC_hos_TPU where BUDGET_YEAR = '2562' and DEPT_ID = '".$Hid."' order by Total_Total_Amount DESC;";
        $TPU_result = DB::select($query_tpu);

        $query_total_drug = "SELECT DEPT_ID, DEPT_NAME, sum(Total_Amount) as Total_Total_Amount, FORMAT(sum(Total_Amount), N'N0') as Total_Amount ";
        $query_total_drug .= "FROM PAC_hos_TPU where BUDGET_YEAR = '2562' and DEPT_ID = '".$Hid."' group by DEPT_ID, DEPT_NAME order by Total_Total_Amount DESC;";
        $query_total_drug_result = DB::select($query_total_drug);
        $total_drug = $query_total_drug_result[0]->Total_Total_Amount;

        $top5_GPU_name = [];
        $top5_GPU_amount = [];
        $top5_TPU_name = [];
        $top5_TPU_amount = [];
        $other_GPU = $total_drug;
        $other_TPU = $total_drug;
        for($i=0 ; $i<5 ; $i++){
            $GPU_name = $GPU_result[$i]->GPU_NAME;
            $GPU_amount = $GPU_result[$i]->Total_Total_Amount;
            array_push($top5_GPU_name, $GPU_name);
            array_push($top5_GPU_amount, $GPU_amount);
            $other_GPU = $other_GPU-$GPU_amount;

            $TPU_name = $TPU_result[$i]->TPU_NAME;
            $TPU_amount = $TPU_result[$i]->Total_Total_Amount;
            array_push($top5_TPU_name, $TPU_name);
            array_push($top5_TPU_amount, $TPU_amount);
            $other_TPU = $other_TPU-$TPU_amount;
        }
        array_push($top5_GPU_amount, $other_GPU);
        array_push($top5_TPU_amount, $other_TPU);

        return [$Hname, $GPU_result, $TPU_result, $top5_GPU_name, $top5_GPU_amount, $top5_TPU_name, $top5_TPU_amount];
    }
}
