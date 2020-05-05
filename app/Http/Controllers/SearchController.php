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
            ////////////////////////////////////////////////////////////////////
            ///// count each region ////////////////////////////////////////////
            if($method == 'All'){
                ////// table show //////////////////////////////////////////////////////////////////////
                $statement = "select * from Gini_drugs_TPU where BUDGET_YEAR = ".$year." and ".$GT."_NAME = '".$Dname."';";
                $resultSearch = DB::select($statement);
                ////////////// stack bar chart ////////////////////////////////////////////////////////////
                $countquery_r1 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '1'";
                $countquery_r2 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '2'";
                $countquery_r3 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '3'";
                $countquery_r4 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '4'";
                $countquery_r5 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '5'";
                $countquery_r6 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '6'";
                $countquery_r7 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '7'";
                $countquery_r8 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '8'";
                $countquery_r9 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '9'";
                $countquery_r10 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '10'";
                $countquery_r11 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '11'";
                $countquery_r12 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '12'";
                $countquery_r13 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '13'";
                ////// Thai map //////////////////////////////////////////////////////////////////////
                $thaimap_query = "select Region, sum(CAST(Total_Amount as float) * CAST(wavg_Unit_Price as float))/sum(CAST(Total_Amount as float)) as wavg_unit_price, sum(Total_Amount) as Total_Amount from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' group by Region";
            }else{
                ////// table show //////////////////////////////////////////////////////////////////////
                $statement = "select * from Gini_drugs_TPU where BUDGET_YEAR = ".$year." and Method = '".$method."' and ".$GT."_NAME = '".$Dname."';";
                $resultSearch = DB::select($statement);
                ////////////stack bar chart///////////////////////////////////////////////////////////
                $countquery_r1 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '1' and Method ='".$method."'";
                $countquery_r2 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '2' and Method ='".$method."'";
                $countquery_r3 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '3' and Method ='".$method."'";
                $countquery_r4 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '4' and Method ='".$method."'";
                $countquery_r5 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '5' and Method ='".$method."'";
                $countquery_r6 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '6' and Method ='".$method."'";
                $countquery_r7 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '7' and Method ='".$method."'";
                $countquery_r8 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '8' and Method ='".$method."'";
                $countquery_r9 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '9' and Method ='".$method."'";
                $countquery_r10 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '10' and Method ='".$method."'";
                $countquery_r11 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '11' and Method ='".$method."'";
                $countquery_r12 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '12' and Method ='".$method."'";
                $countquery_r13 = "select Count(DEPT_ID) as n from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Region = '13' and Method ='".$method."'";    
                ////// Thai map //////////////////////////////////////////////////////////////////////
                $thaimap_query = "select Region, sum(CAST(Total_Amount as float) * CAST(wavg_Unit_Price as float))/sum(CAST(Total_Amount as float)) as wavg_unit_price, sum(Total_Amount) as Total_Amount from [PAC_hos_".$GT."] where BUDGET_YEAR = '".$year."' and ".$GT."_NAME ='".$Dname."' and Method = '".$method."' group by Region";
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

            ///// create array for stack bar chart ////////////////////////////////////////////////
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

        // print($statement);
        // dump(gettype($resultSearch));
        // print(count($resultSearch));
        ///////////////////////////////////////////////////////////////////////////////////////
        //////////////Start Thai Map///////////////////////////////////////////////////////////
        $resultThaiMap = DB::select($thaimap_query);
        $Region_1 = ['TH-50','TH-57','TH-51','TH-52','TH-54','TH-55','TH-56','TH-58'];
        $Region_2 = ['TH-65','TH-67','TH-53','TH-63','TH-64'];
        $Region_3 = ['TH-60','TH-62','TH-66','TH-61','TH-18'];
        $Region_4 = ['TH-17','TH-16','TH-19','TH-12','TH-14','TH-15','TH-13','TH-26'];
        $Region_5 = ['TH-70','TH-72','TH-73','TH-71','TH-75','TH-74','TH-76','TH-77'];
        $Region_6 = ['TH-20','TH-21','TH-22','TH-23','TH-11','TH-24','TH-25','TH-27'];
        $Region_7 = ['TH-40','TH-44','TH-45','TH-46'];
        $Region_8 = ['TH-41','TH-47','TH-48','TH-42','TH-39','TH-43']; //+'บึงกาฬ'
        $Region_9 = ['TH-30','TH-36','TH-31','TH-32'];
        $Region_10 = ['TH-34','TH-33','TH-35','TH-37','TH-49'];
        $Region_11 = ['TH-86','TH-85','TH-84','TH-80','TH-82','TH-81','TH-83'];
        $Region_12 = ['TH-96','TH-94','TH-95','TH-90','TH-91','TH-93','TH-92'];
        $Region_13 = ['TH-10'];

        for($i=0 ; $i< count($resultThaiMap) ; $i++){
            $reg = $resultThaiMap[$i]->Region;
            $quan = $resultThaiMap[$i]->Total_Amount;
            $pri = $resultThaiMap[$i]->wavg_unit_price;
            $xx = 0;
            // if($xx < 10){
            //     $color = 'red';
            // }else if($xx >= 10 && $xx < 100){
            //     $color = 'yellow';
            // }else if($xx >= 100){
            //     $color = 'green';
            // }
            if($reg == 1){
                foreach ($Region_1 as &$ii) {
                    $quan_array_1[$ii] = $quan;
                    $pri_array_1[$ii] = $pri;
                }
            }else if($reg == 2){
                foreach ($Region_2 as &$ii) {
                    $quan_array_2[$ii] = $quan;
                    $pri_array_2[$ii] = $pri;
                }
            }else if($reg == 3){
                foreach ($Region_3 as &$ii) {
                    $quan_array_3[$ii] = $quan;
                    $pri_array_3[$ii] = $pri;
                }
            }else if($reg == 4){
                foreach ($Region_4 as &$ii) {
                    $quan_array_4[$ii] = $quan;
                    $pri_array_4[$ii] = $pri;
                }
            }else if($reg == 5){
                foreach ($Region_5 as &$ii) {
                    $quan_array_5[$ii] = $quan;
                    $pri_array_5[$ii] = $pri;
                }
            }else if($reg == 6){
                foreach ($Region_6 as &$ii) {
                    $quan_array_6[$ii] = $quan;
                    $pri_array_6[$ii] = $pri;
                }
            }else if($reg == 7){
                foreach ($Region_7 as &$ii) {
                    $quan_array_7[$ii] = $quan;
                    $pri_array_7[$ii] = $pri;
                }
            }else if($reg == 8){
                foreach ($Region_8 as &$ii) {
                    $quan_array_8[$ii] = $quan;
                    $pri_array_8[$ii] = $pri;
                }
            }else if($reg == 9){
                foreach ($Region_9 as &$ii) {
                    $quan_array_9[$ii] = $quan;
                    $pri_array_9[$ii] = $pri;
                }
            }else if($reg == 10){
                foreach ($Region_10 as &$ii) {
                    $quan_array_10[$ii] = $quan;
                    $pri_array_10[$ii] = $pri;
                }
            }else if($reg == 11){
                foreach ($Region_11 as &$ii) {
                    $quan_array_11[$ii] = $quan;
                    $pri_array_11[$ii] = $pri;
                }
            }else if($reg == 12){
                foreach ($Region_12 as &$ii) {
                    $quan_array_12[$ii] = $quan;
                    $pri_array_12[$ii] = $pri;
                }
            }else if($reg == 13){
                foreach ($Region_13 as &$ii) {
                    $quan_array_13[$ii] = $quan;
                    $pri_array_13[$ii] = $pri;
                }
            }
        }
        $quan_array_all = array_merge($quan_array_1, $quan_array_2, $quan_array_3, $quan_array_4, $quan_array_5, $quan_array_6, $quan_array_7, $quan_array_8, $quan_array_9, $quan_array_10, $quan_array_11, $quan_array_12, $quan_array_13);
        $pri_array_all = array_merge($pri_array_1, $pri_array_2, $pri_array_3, $pri_array_4, $pri_array_5, $pri_array_6, $pri_array_7, $pri_array_8, $pri_array_9, $pri_array_10, $pri_array_11, $pri_array_12, $pri_array_13);

        // $mapp = (object) ['TH-30' => 'purple', 'TH-20' => 'yellow'];
        // $mapp = "{'TH-30':'purple', 'TH-20':'red'}";


        //////////////END Thai Map/////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////
        //////////////Send data back to view///////////////////////////////////////////////////
        if(empty($resultSearch))
        {
            $resultSearch = 'No value';
            $chartLowPercent = NULL;
            $chartMedPercent = NULL;
            $chartHighPercent = NULL;
            $resultState = 'Please select again';
            $pri_array_all = NULL;
            $quan_array_all = NULL;
        }
        $send_data = array(
            'resultSearch'=>$resultSearch,
            'chartLowPercent'=>$chartLowPercent,
            'chartMedPercent'=>$chartMedPercent,
            'chartHighPercent'=>$chartHighPercent,
            'resultState'=>$resultState,
            // 'mapp'=>$mapp,
            'pri_array_all'=>$pri_array_all,
            'quan_array_all'=>$quan_array_all
        );
        return view('DrugPage', $send_data);
    }
}
