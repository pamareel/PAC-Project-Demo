<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HospitalDashboardController extends Controller
{
    public function index($year, $Hid){
        $Year = $year;
        $HID = $Hid;
        [$Htype, $Hprovince, $Hregion, $Hip, $Hop, $Htpu] = $this->hospital_info($Hid, $year);
        [$Hname, $donut_hos_drug_GPU, $donut_hos_drug_TPU, $top5_GPU_name, $top5_GPU_amount, $top5_TPU_name, $top5_TPU_amount, $total_drug] = $this->Donut_Hospital($year,$Hid);
        if($donut_hos_drug_GPU != null){
            $GPU_table_Donut = $this->table_GPU_Donut_Hospital($donut_hos_drug_GPU);
            $TPU_table_Donut = $this->table_TPU_Donut_Hospital($donut_hos_drug_TPU);

            [$perfLowPercent_GPU, $perfHighPercent_GPU] = $this->GPU_perf_Chart_Hospital($Hid, 'GPU', $year, $donut_hos_drug_GPU);
            [$perfLowPercent_TPU, $perfHighPercent_TPU] = $this->TPU_perf_Chart_Hospital($Hid, 'TPU', $year, $donut_hos_drug_TPU);

            [$GPU_Cost_saving_table_hos, $totalPotentialSave_GPU, $totalSpend_GPU, $totalSuggestSpend_GPU, $totalSpend_GPU_label, $totalSuggestSpend_GPU_label] = $this->table_GPU_cost_saving_Hospital($Hid, $year);
            [$TPU_Cost_saving_table_hos, $totalPotentialSave_TPU, $totalSpend_TPU, $totalSuggestSpend_TPU, $totalSpend_TPU_label, $totalSuggestSpend_TPU_label] = $this->table_TPU_cost_saving_Hospital($Hid, $year);
            
            [$totalSpend_60, $totalSpend_label_60] = $this->total_spend_hos($Hid, '2560');
            [$totalSpend_61, $totalSpend_label_61] = $this->total_spend_hos($Hid, '2561');
            [$totalSpend_62, $totalSpend_label_62] = $this->total_spend_hos($Hid, '2562');
        }else{
            $GPU_table_Donut = null;
            $TPU_table_Donut = null;

            [$perfLowPercent_GPU, $perfHighPercent_GPU] = [null, null];
            [$perfLowPercent_TPU, $perfHighPercent_TPU] = [null, null];

            [$GPU_Cost_saving_table_hos, $totalPotentialSave_GPU, $totalSpend_GPU, $totalSuggestSpend_GPU, $totalSpend_GPU_label, $totalSuggestSpend_GPU_label] = [null, null, null, null, null, null];
            [$TPU_Cost_saving_table_hos, $totalPotentialSave_TPU, $totalSpend_TPU, $totalSuggestSpend_TPU, $totalSpend_TPU_label, $totalSuggestSpend_TPU_label] = [null, null, null, null, null, null];
            
            [$totalSpend_60, $totalSpend_label_60] = [null, null];
            [$totalSpend_61, $totalSpend_label_61] = [null, null];
            [$totalSpend_62, $totalSpend_label_62] = [null, null];
        }
        $sendData = array(
            'Htype'=>$Htype, 'Hprovince'=>$Hprovince, 'Hregion'=>$Hregion, 'Hip'=>$Hip, 'Hop'=>$Hop, 'Htpu'=>$Htpu,
            'Year'=>$Year,
            'HID'=>$HID,
            'Hname'=>$Hname,
            'donut_hos_drug_GPU'=>$donut_hos_drug_GPU,
            'donut_hos_drug_TPU'=>$donut_hos_drug_TPU,
            'top5_GPU_name'=>$top5_GPU_name, 'top5_GPU_amount'=>$top5_GPU_amount,
            'top5_TPU_name'=>$top5_TPU_name, 'top5_TPU_amount'=>$top5_TPU_amount,
            'total_drug'=>$total_drug,
            'GPU_table_Donut'=>$GPU_table_Donut, 'TPU_table_Donut'=>$TPU_table_Donut,
            'perfLowPercent_GPU'=>$perfLowPercent_GPU, 'perfHighPercent_GPU'=>$perfHighPercent_GPU,
            'perfLowPercent_TPU'=>$perfLowPercent_TPU, 'perfHighPercent_TPU'=>$perfHighPercent_TPU,
            'GPU_Cost_saving_table_hos'=>$GPU_Cost_saving_table_hos,
            'totalPotentialSave_GPU'=>$totalPotentialSave_GPU,
            'totalSpend_GPU'=>$totalSpend_GPU, 'totalSuggestSpend_GPU'=>$totalSuggestSpend_GPU,
            'totalSpend_GPU_label'=>$totalSpend_GPU_label, 'totalSuggestSpend_GPU_label'=>$totalSuggestSpend_GPU_label,
            'TPU_Cost_saving_table_hos'=>$TPU_Cost_saving_table_hos,
            'totalPotentialSave_TPU'=>$totalPotentialSave_TPU,
            'totalSpend_TPU'=>$totalSpend_TPU, 'totalSuggestSpend_TPU'=>$totalSuggestSpend_TPU,
            'totalSpend_TPU_label'=>$totalSpend_TPU_label, 'totalSuggestSpend_TPU_label'=>$totalSuggestSpend_TPU_label,
            'totalSpend_60'=>$totalSpend_60, 'totalSpend_label_60'=>$totalSpend_label_60,
            'totalSpend_61'=>$totalSpend_61, 'totalSpend_label_61'=>$totalSpend_label_61,
            'totalSpend_62'=>$totalSpend_62, 'totalSpend_label_62'=>$totalSpend_label_62,

        );
        return view('HospitalDashboardPage', $sendData);
    }

    function Donut_Hospital($year,$Hid){
        // $query_rd = "SELECT DEPT_ID, DEPT_NAME, ServicePlanType, PROVINCE_EN, Region, FORMAT(IP, N'N0') as IP, FORMAT(OP, N'N0') as OP, ";
        // $query_rd .= "CONVERT(varchar, CAST(Total_Spend as money), 1) as Total_Spend FROM Hos_detail ";
        // $query_rd .= "where BUDGET_YEAR = '".$year."' and DEPT_ID ='".$Hid."';";

        $query_gpu = "SELECT DEPT_ID, DEPT_NAME, GPU_ID, GPU_NAME, cast(wavg_unit_price as decimal(18,3)) as wavg_unit_price, Total_Amount as Total_Total_Amount, FORMAT(Total_Amount, N'N0') as Total_Amount, PAC_value ";
        $query_gpu .= "FROM PAC_hos_GPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."' order by Total_Total_Amount DESC;";
        $GPU_result = DB::select($query_gpu);
        if(count($GPU_result)>0){
            $Hname = $GPU_result[0]->DEPT_NAME;

            $query_tpu = "SELECT DEPT_ID, DEPT_NAME, TPU_ID, TPU_NAME, cast(wavg_unit_price as decimal(18,3)) as wavg_unit_price, Total_Amount as Total_Total_Amount, FORMAT(Total_Amount, N'N0') as Total_Amount, PAC_value ";
            $query_tpu .= "FROM PAC_hos_TPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."' order by Total_Total_Amount DESC;";
            $TPU_result = DB::select($query_tpu);

            $query_total_drug = "SELECT DEPT_ID, DEPT_NAME, sum(Total_Amount) as Total_Total_Amount, FORMAT(sum(Total_Amount), N'N0') as Total_Amount ";
            $query_total_drug .= "FROM PAC_hos_TPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."' group by DEPT_ID, DEPT_NAME order by Total_Total_Amount DESC;";
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
            
            $total_drug = $query_total_drug_result[0]->Total_Amount;
        }else{
            $Hname = null; $GPU_result=[]; $TPU_result=[]; $top5_GPU_name=[];
            $top5_GPU_amount= []; $top5_TPU_name= []; $top5_TPU_amount= []; $total_drug= null;
        }
        
        return [$Hname, $GPU_result, $TPU_result, $top5_GPU_name, $top5_GPU_amount, $top5_TPU_name, $top5_TPU_amount, $total_drug];
    }

    function table_GPU_Donut_Hospital($result){
        $content = '';
        // $color = [["#edf2f6","#5f76e8","#ff4f70","#01caf1","yellow","pink"]];
        for ($i = 0; $i < Count($result) ; $i++) {
            $content .= '<tr>';
            // $content .= '<td style="text-align:center;"><i class="fas fa-circle font-10 mr-2" style="color:'.$color[$i].';"></td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->GPU_ID.'</td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->GPU_NAME.'</td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->wavg_unit_price.'</td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->Total_Amount.'</td>';
            $content .= '</tr>';
        }
        return $content;
    }
    function table_TPU_Donut_Hospital($result){
        $content = '';
        // $color = [["#edf2f6","#5f76e8","#ff4f70","#01caf1","yellow","pink"]];
        for ($i = 0; $i < Count($result) ; $i++) {
            $content .= '<tr>';
            // $content .= '<td style="text-align:center;"><i class="fas fa-circle font-10 mr-2" style="color:'.$color[$i].';"></td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->TPU_ID.'</td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->TPU_NAME.'</td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->wavg_unit_price.'</td>';
            $content .= '<td style="text-align:left;">'.$result[$i]->Total_Amount.'</td>';
            $content .= '</tr>';
        }
        return $content;
    }
    function GPU_perf_Chart_Hospital($Hid, $GT, $year, $query){
        $perfLow = 0;
        $perfHigh = 0;
        for($i=0 ; $i<Count($query) ; $i++){
            $GID = $query[$i]->GPU_ID;
            $query_AVG = "select AVG(PAC_value) as avg from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_ID ='".$GID."'";
            $AVG = DB::select($query_AVG);
            $avg = $AVG[0]->avg;

            $PAC_h = $query[$i]->PAC_value;
            if($PAC_h < $avg){
                $perfLow = $perfLow+1;
            }else if($PAC_h >= $avg){
                $perfHigh = $perfHigh+1;
            }
        }
        $perfLowPercent = 100*$perfLow/Count($query);
        $perfHighPercent = 100*$perfHigh/Count($query);
        return [$perfLowPercent, $perfHighPercent];
    }
    function TPU_perf_Chart_Hospital($Hid, $GT, $year, $query){
        $perfLow = 0;
        $perfHigh = 0;
        for($i=0 ; $i<Count($query) ; $i++){
            $TID = $query[$i]->TPU_ID;
            $query_AVG = "select AVG(PAC_value) as avg from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_ID ='".$TID."'";
            $AVG = DB::select($query_AVG);
            $avg = $AVG[0]->avg;

            $PAC_h = $query[$i]->PAC_value;
            if($PAC_h < $avg){
                $perfLow = $perfLow+1;
            }else if($PAC_h >= $avg){
                $perfHigh = $perfHigh+1;
            }
        }
        $perfLowPercent = 100*$perfLow/Count($query);
        $perfHighPercent = 100*$perfHigh/Count($query);
        return [$perfLowPercent, $perfHighPercent];
    }
    function table_GPU_cost_saving_Hospital($Hid, $year){
        $query_gpu = "SELECT GPU_ID, GPU_NAME, Real_Total_Spend as Real_Real_Total_Spend, FORMAT(Real_Total_Spend, N'N0') as Real_Total_Spend, Potential_Saving_Cost as Poten_Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N0') as Potential_Saving_Cost, Percent_saving as PS_Percent_saving, cast(Percent_saving as decimal(10,2)) as Percent_saving, suggested_spending ";
        $query_gpu .= "FROM CostSaving_hos where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."' order by PS_Percent_saving DESC;";
        $GPU_result = DB::select($query_gpu);
        
        $content = '';

        for ($i = 0; $i < Count($GPU_result) ; $i++) {

            $Potential_Saving_Cost = $GPU_result[$i]->Potential_Saving_Cost;
            $Percent_saving = $GPU_result[$i]->Percent_saving;
            if($GPU_result[$i]->Poten_Potential_Saving_Cost < 0 && $GPU_result[$i]->PS_Percent_saving <0){
                $Potential_Saving_Cost = '-';
                $Percent_saving = '-';
            }

            $query_count = "SELECT FORMAT(count(TPU_ID), N'N0') as Count_TPU ";
            $query_count .= "FROM CostSaving_hos_TPU where BUDGET_YEAR = '".$year."' and GPU_ID = '".$GPU_result[$i]->GPU_ID."' and DEPT_ID = '".$Hid."';";
            $count_result = DB::select($query_count);
            $Htpu = $count_result[0]->Count_TPU;

            $content .= '<tr>';
            $content .= '<td style="text-align:left;">'.$GPU_result[$i]->GPU_ID.'</td>';
            $content .= '<td style="text-align:left;">'.$GPU_result[$i]->GPU_NAME.'</td>';
            $content .= '<td style="text-align:center;">'.$Htpu.'</td>';
            $content .= '<td style="text-align:right; padding-right:12px;">'.$GPU_result[$i]->Real_Total_Spend.'</td>';
            $content .= '<td style="text-align:right; padding-right:15px;">'.$Potential_Saving_Cost.'</td>';
            $content .= '<td style="text-align:center;">'.$Percent_saving .'</td>';
            $content .= '</tr>';
        }

        $totalSpend_query = "SELECT FORMAT(sum(Real_Total_Spend), N'N0') as s, sum(Real_Total_Spend) as Real_Total_Spend ";
        $totalSpend_query .= "FROM CostSaving_hos where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."';";
        $totalSpend_result = DB::select($totalSpend_query);
        $totalSpend = $totalSpend_result[0]->Real_Total_Spend;
        $totalSpend_label = $totalSpend_result[0]->s;

        $totalPotentialSave_query = "SELECT FORMAT(sum(Potential_Saving_Cost), N'N0') as sc, cast(sum(suggested_spending) as decimal(10,2)) as s_suggested_spending, CONVERT(varchar, CAST(sum(suggested_spending) as money), 1) as sp ";
        $totalPotentialSave_query .= "FROM CostSaving_hos where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."' and Potential_Saving_Cost >=0;";
        $totalPotentialSave_result = DB::select($totalPotentialSave_query);
        $totalPotentialSave = $totalPotentialSave_result[0]->sc;
        $totalSuggestSpend = $totalPotentialSave_result[0]->s_suggested_spending;
        $totalSuggestSpend_label = $totalPotentialSave_result[0]->sp;

        return [$content, $totalPotentialSave, $totalSpend, $totalSuggestSpend, $totalSpend_label, $totalSuggestSpend_label];
    }
    function table_TPU_cost_saving_Hospital($Hid, $year){
        $query_tpu = "SELECT GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, Real_Total_Spend as Real_Real_Total_Spend, FORMAT(Real_Total_Spend, N'N0') as Real_Total_Spend, Potential_Saving_Cost as Poten_Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N0') as Potential_Saving_Cost, Percent_saving as PS_Percent_saving, cast(Percent_saving as decimal(10,2)) as Percent_saving, suggested_spending ";
        $query_tpu .= "FROM CostSaving_hos_TPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."' order by PS_Percent_saving DESC;";
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

        $totalSpend_query = "SELECT FORMAT(sum(Real_Total_Spend), N'N0') as s, sum(Real_Total_Spend) as Real_Total_Spend ";
        $totalSpend_query .= "FROM CostSaving_hos_TPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."';";
        $totalSpend_result = DB::select($totalSpend_query);
        $totalSpend = $totalSpend_result[0]->Real_Total_Spend;
        $totalSpend_label = $totalSpend_result[0]->s;

        $totalPotentialSave_query = "SELECT FORMAT(sum(Potential_Saving_Cost), N'N0') as sc, cast(sum(suggested_spending) as decimal(10,2)) as s_suggested_spending, CONVERT(varchar, CAST(sum(suggested_spending) as money), 1) as sp ";
        $totalPotentialSave_query .= "FROM CostSaving_hos_TPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."' and Potential_Saving_Cost >=0;";
        $totalPotentialSave_result = DB::select($totalPotentialSave_query);
        $totalPotentialSave = $totalPotentialSave_result[0]->sc;
        $totalSuggestSpend = $totalPotentialSave_result[0]->s_suggested_spending;
        $totalSuggestSpend_label = $totalPotentialSave_result[0]->sp;

        return [$content, $totalPotentialSave, $totalSpend, $totalSuggestSpend, $totalSpend_label, $totalSuggestSpend_label];
    }
    function total_spend_hos($Hid, $year){
        $totalSpend_query = "SELECT FORMAT(sum(Real_Total_Spend), N'N0') as s, sum(Real_Total_Spend) as Real_Total_Spend ";
        $totalSpend_query .= "FROM CostSaving_hos_TPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."';";
        $totalSpend_result = DB::select($totalSpend_query);
        $totalSpend = $totalSpend_result[0]->Real_Total_Spend;
        $totalSpend_label = $totalSpend_result[0]->s;
        return [$totalSpend, $totalSpend_label];
    }
    function hospital_info($Hid, $year){
        $query_hos = "select DISTINCT DEPT_NAME, ServicePlanType, PROVINCE_EN, Region,IP,OP from PAC_hos_GPU where DEPT_ID = '".$Hid."';";
        $hos_result = DB::select($query_hos);
        $Htype = $hos_result[0]->ServicePlanType;
        $Hprovince = $hos_result[0]->PROVINCE_EN;
        $Hregion = $hos_result[0]->Region;
        $Hip = $hos_result[0]->IP;
        $Hop = $hos_result[0]->OP;

        $query_count = "SELECT FORMAT(count(TPU_ID), N'N0') as Count_TPU ";
        $query_count .= "FROM CostSaving_hos_TPU where BUDGET_YEAR = '".$year."' and DEPT_ID = '".$Hid."';";
        $count_result = DB::select($query_count);
        $Htpu = $count_result[0]->Count_TPU;

        return [$Htype, $Hprovince, $Hregion, $Hip, $Hop, $Htpu];
    }
}
