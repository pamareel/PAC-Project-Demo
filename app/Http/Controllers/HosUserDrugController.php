<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HosUserDrugController extends Controller
{
    public function index(){
        if (!empty($_GET)){
            $year = $_GET['year'];
            $method = $_GET['method'];
            $GT = $_GET['GT'];
            $Dname= $_GET['Dname'];

            $Hid = '1074700';

            if($Dname != null){
                if($GT == 'GPU'){
                    $Dname = $Dname.'%';
                }else if($GT == 'TPU'){
                    $Dname = '%'.$Dname.'%';
                }
                $resultCostSave = [];
                if($method == 'All'){
                    ////// table show //////////////////////////////////////////////////////////////////////
                    $statement = "select BUDGET_YEAR, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, Method, ";
                    $statement .= "Total_Amount,  FORMAT(Total_Amount, N'N2') as To_Total_Amount, ";
                    $statement .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                    $statement .= "Total_Spend, FORMAT(Total_Spend, N'N2') as To_Total_Spend, ";
                    $statement .= "cast(PAC_value as decimal(10,3)) as PAC_value ";
                    $statement .= "from PAC_hos_TPU where BUDGET_YEAR = ".$year." and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                    $resultSearch = DB::select($statement);

                    if($resultSearch != []){
                        if($GT == "GPU"){
                            $statement2 = "select BUDGET_YEAR, GPU_ID, GPU_NAME, Method, ";
                            $statement2 .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                            $statement2 .= "cast(suggested_unit_price as decimal(10,2)) as suggested_unit_price,";
                            $statement2 .= "Total_Amount, FORMAT(Total_Amount, N'N2') as T_Total_Amount, ";
                            $statement2 .= "suggested_spending, FORMAT(suggested_spending, N'N2') as s_suggested_spending, ";
                            $statement2 .= "Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N2') as P_Potential_Saving_Cost, ";
                            $statement2 .= "cast(Percent_saving as decimal(10,2)) as Percent_saving ";
                            $statement2 .= "from CostSaving_hos where BUDGET_YEAR = ".$year." and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                        }else if($GT == "TPU"){
                            $statement2 = "select BUDGET_YEAR, TPU_NAME, ";
                            $statement2 .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                            $statement2 .= "cast(suggested_unit_price as decimal(10,2)) as suggested_unit_price,";
                            $statement2 .= "Total_Amount, FORMAT(Total_Amount, N'N2') as T_Total_Amount, ";
                            $statement2 .= "suggested_spending, FORMAT(suggested_spending, N'N2') as s_suggested_spending, ";
                            $statement2 .= "Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N2') as P_Potential_Saving_Cost, ";
                            $statement2 .= "cast(Percent_saving as decimal(10,2)) as Percent_saving ";
                            $statement2 .= "from CostSaving_hos_TPU where BUDGET_YEAR = ".$year." and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                        }
                        $resultCostSave = DB::select($statement2);
                    }

                }else{
                    ////// table show //////////////////////////////////////////////////////////////////////
                    $statement = "select BUDGET_YEAR, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, Method, ";
                    $statement .= "Total_Amount,  FORMAT(Total_Amount, N'N2') as To_Total_Amount, ";
                    $statement .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                    $statement .= "Total_Spend, FORMAT(Total_Spend, N'N2') as To_Total_Spend, ";
                    $statement .= "cast(PAC_value as decimal(10,3)) as PAC_value ";
                    $statement .= "from PAC_hos_TPU where BUDGET_YEAR = ".$year." and Method = '".$method."' and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                    
                    $resultSearch = DB::select($statement);

                    if($resultSearch != []){
                        if($GT == "GPU"){
                            $statement2 = "select BUDGET_YEAR, GPU_ID, GPU_NAME, Method, ";
                            $statement2 .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                            $statement2 .= "cast(suggested_unit_price as decimal(10,2)) as suggested_unit_price,";
                            $statement2 .= "Total_Amount, FORMAT(Total_Amount, N'N2') as T_Total_Amount, ";
                            $statement2 .= "suggested_spending, FORMAT(suggested_spending, N'N2') as s_suggested_spending, ";
                            $statement2 .= "Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N2') as P_Potential_Saving_Cost, ";
                            $statement2 .= "cast(Percent_saving as decimal(10,2)) as Percent_saving ";
                            $statement2 .= "from CostSaving_hos where BUDGET_YEAR = ".$year." and Method = '".$method."' and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                        }else if($GT == "TPU"){
                            $statement2 = "select BUDGET_YEAR, TPU_NAME, ";
                            $statement2 .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                            $statement2 .= "cast(suggested_unit_price as decimal(10,2)) as suggested_unit_price,";
                            $statement2 .= "Total_Amount, FORMAT(Total_Amount, N'N2') as T_Total_Amount, ";
                            $statement2 .= "suggested_spending, FORMAT(suggested_spending, N'N2') as s_suggested_spending, ";
                            $statement2 .= "Potential_Saving_Cost, FORMAT(Potential_Saving_Cost, N'N2') as P_Potential_Saving_Cost, ";
                            $statement2 .= "cast(Percent_saving as decimal(10,2)) as Percent_saving ";
                            $statement2 .= "from CostSaving_hos_TPU where BUDGET_YEAR = ".$year." and Method = '".$method."' and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                        }
                        $resultCostSave = DB::select($statement2);
                    }
                }
                if($resultCostSave != []){
                    if($GT == 'GPU'){
                        $resultState = "".$year.", ".$method." method, ".$GT."-level, ".$resultSearch[0]->GPU_NAME."";
                    }else if($GT == 'TPU'){
                        $resultState = "".$year.", ".$method." method, ".$GT."-level, ".$resultSearch[0]->TPU_NAME."";
                    }
                }else{
                    $resultState = '';
                }
            }else{
                $resultSearch = 'No Dname';
                $resultState = '';
                $resultCostSave = [];
            }
        }
        if($resultSearch == []){
            $resultSearch = 'No value';
            $resultState = '';
            $resultCostSave = [];
        }
        $send_data = array(
            'resultSearch'=>$resultSearch,
            'resultState'=>$resultState,
            'resultCostSave'=>$resultCostSave
        );
        return view('DrugHosUser', $send_data);
    }
}
