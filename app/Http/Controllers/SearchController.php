<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function index(){

        if (!empty($_GET)){
            $year = $_GET['year'];
            $method = $_GET['method'];
            $GT = $_GET['GT'];
            $Dname= $_GET['Dname'];
            $resultState = "".$year.", ".$method." method, ".$GT."-level, ".$Dname."";
            // dump($_GET);
            // echo "<p>Your drug name is <b>" . $Dname . "</b>.</p>";
            ///// count each region ////////////////////////////////////////////
            if($method == 'All'){
                ////// table show ////////////////////////////////////////////////
                $statement = "select * from Gini_drugs_TPU where BUDGET_YEAR = ".$year." and ".$GT."_NAME = '".$Dname."';";
                $resultSearch = DB::select($statement);
                dump('Hi');
                $countquery_r1 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '1'";
                $countquery_r2 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '2'";
                $countquery_r3 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '3'";
                $countquery_r4 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '4'";
                $countquery_r5 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '5'";
                $countquery_r6 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '6'";
                $countquery_r7 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '7'";
                $countquery_r8 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '8'";
                $countquery_r9 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '9'";
                $countquery_r10 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '10'";
                $countquery_r11 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '11'";
                $countquery_r12 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '12'";
                $countquery_r13 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '13'";
            }else{
                ////// table show ////////////////////////////////////////////////
                $statement = "select * from Gini_drugs_TPU where BUDGET_YEAR = ".$year." and Method = '".$method."' and ".$GT."_NAME = '".$Dname."';";
                $resultSearch = DB::select($statement);

                $countquery_r1 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '1' and Method ='".$method."'";
                $countquery_r2 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '2' and Method ='".$method."'";
                $countquery_r3 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '3' and Method ='".$method."'";
                $countquery_r4 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '4' and Method ='".$method."'";
                $countquery_r5 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '5' and Method ='".$method."'";
                $countquery_r6 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '6' and Method ='".$method."'";
                $countquery_r7 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '7' and Method ='".$method."'";
                $countquery_r8 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '8' and Method ='".$method."'";
                $countquery_r9 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '9' and Method ='".$method."'";
                $countquery_r10 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '10' and Method ='".$method."'";
                $countquery_r11 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '11' and Method ='".$method."'";
                $countquery_r12 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '12' and Method ='".$method."'";
                $countquery_r13 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and GPU_NAME ='".$Dname."' and Region = '13' and Method ='".$method."'";    
            }
            $r1 = DB::select($countquery_r1);
            if($r1 != null){
                $r1_count = $r1[0]->n;
            }else{
                $r1_count = 0;
            }
            $r2 = DB::select($countquery_r2);
            if($r2 != null){
                $r2_count = $r2[0]->n;
            }else{
                $r2_count = 0;
            }
            $r3 = DB::select($countquery_r3);
            if($r3 != null){
                $r3_count = $r3[0]->n;
            }else{
                $r3_count = 0;
            }
            $r4 = DB::select($countquery_r4);
            if($r4 != null){
                $r4_count = $r4[0]->n;
            }else{
                $r4_count = 0;
            }
            $r5 = DB::select($countquery_r5);
            if($r5 != null){
                $r5_count = $r5[0]->n;
            }else{
                $r5_count = 0;
            }
            $r6 = DB::select($countquery_r6);
            if($r6 != null){
                $r6_count = $r6[0]->n;
            }else{
                $r6_count = 0;
            }
            $r7 = DB::select($countquery_r7);
            if($r7 != null){
                $r7_count = $r7[0]->n;
            }else{
                $r7_count = 0;
            }
            $r8 = DB::select($countquery_r8);
            if($r8 != null){
                $r8_count = $r8[0]->n;
            }else{
                $r8_count = 0;
            }
            $r9 = DB::select($countquery_r9);
            if($r9 != null){
                $r9_count = $r9[0]->n;
            }else{
                $r9_count = 0;
            }
            $r10 = DB::select($countquery_r10);
            if($r10 != null){
                $r10_count = $r10[0]->n;
            }else{
                $r10_count = 0;
            }
            $r11 = DB::select($countquery_r11);
            if($r11 != null){
                $r11_count = $r11[0]->n;
            }else{
                $r11_count = 0;
            }
            $r12 = DB::select($countquery_r12);
            if($r12 != null){
                $r12_count = $r12[0]->n;
            }else{
                $r12_count = 0;
            }
            $r13 = DB::select($countquery_r13);
            if($r13 != null){
                $r13_count = $r13[0]->n;
            }else{
                $r13_count = 0;
            }
            $countHosAll = array();
            array_push($countHosAll,$r1_count,$r2_count,$r3_count,$r4_count,$r5_count,$r6_count,$r7_count,$r8_count,$r9_count,$r10_count,$r11_count,$r12_count,$r13_count);

            ////// init ////////////////////////////////////////////////////////
            $chartRegion = array();
            $chartLowPercent = array();
            $chartMedPercent = array();
            $chartHighPercent = array();

            ///// create array for stack bar chart /////////////////////////////
            for($t=1 ; $t<=13 ; $t++){
                array_push($chartRegion,$t);
                if($method == 'All'){
                    $query_low = "select Region, Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and PAC_value < 0.8 and Region ='".$t."' group by Region";
                    $query_med = "select Region, Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and PAC_value < 1 and PAC_value>=0.8 and Region ='".$t."' group by Region";
                    $query_high = "select Region, Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and PAC_value >= 1 and Region ='".$t."' group by Region";
                }else{
                    $query_low = "select Region, Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and PAC_value < 0.8 and Region ='".$t."' and Method ='".$method."' group by Region";
                    $query_med = "select Region, Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and PAC_value < 1 and PAC_value>=0.8 and Region ='".$t."' and Method ='".$method."' group by Region";
                    $query_high = "select Region, Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and PAC_value >= 1 and Region ='".$t."' and Method ='".$method."' group by Region";
                }

                /////// for Low PAC ////////////////////////////////////////////////
                $lowPac = DB::select($query_low);
                $ttt = $t-1;

                if($lowPac != null && $countHosAll[$ttt] != 0){
                    $Low_dataPercent = 100*($lowPac[0]->n)/$countHosAll[$ttt];
                }else{
                    $Low_dataPercent = 0;
                }
                array_push($chartLowPercent,$Low_dataPercent);

                /////// for Medium PAC ////////////////////////////////////////////////
                $medPac = DB::select($query_med);
                if($medPac != null && $countHosAll[$ttt] != 0){
                    $Med_dataPercent = 100*($medPac[0]->n)/$countHosAll[$ttt];
                }else{
                    $Med_dataPercent = 0;
                }
                array_push($chartMedPercent,$Med_dataPercent);

                /////// for High PAC ////////////////////////////////////////////////
                $highPac = DB::select($query_high);
                if($highPac != null && $countHosAll[$ttt] != 0){
                    $High_dataPercent = 100*($highPac[0]->n)/$countHosAll[$ttt];
                }else{
                    $High_dataPercent = 0;
                }
                array_push($chartHighPercent,$High_dataPercent);  
            }
        }
        // dump($chartHighPercent);
        // dump($chartMedPercent);
        // dump($chartLowPercent);

        // print($statement);
        // dump(gettype($resultSearch));
        // print(count($resultSearch));
        
        if(empty($resultSearch))
        {
            $resultSearch = 'No value';
            $chartLowPercent = NULL;
            $chartMedPercent = NULL;
            $chartHighPercent = NULL;
            $resultState = 'Please select again';
        }
        $send_data = array(
            'resultSearch'=>$resultSearch,
            'chartLowPercent'=>$chartLowPercent,
            'chartMedPercent'=>$chartMedPercent,
            'chartHighPercent'=>$chartHighPercent,
            'resultState'=>$resultState
        );
        // dump($resultState);
        // dump($resultSearch);
        
        return view('DrugPage', $send_data);
    }
}
