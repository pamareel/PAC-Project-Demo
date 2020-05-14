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
            $resultState = "".$year.", ".$method." method, ".$GT."-level, ".$Dname."";

            $Hid = '1070200';

            if($GT == 'GPU'){
                $Dname = $Dname.'%';
            }else if($GT == 'TPU'){
                $Dname = '%'.$Dname.'%';
            }
            if($method == 'All'){
                ////// table show //////////////////////////////////////////////////////////////////////
                $statement = "select BUDGET_YEAR, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, Method, ";
                $statement .= "Total_Amount,  FORMAT(Total_Amount, N'N0') as To_Total_Amount, ";
                $statement .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                $statement .= "Total_Spend, FORMAT(Total_Spend, N'N0') as To_Total_Spend, ";
                $statement .= "cast(PAC_value as decimal(10,3)) as PAC_value ";
                $statement .= "from PAC_hos_TPU where BUDGET_YEAR = ".$year." and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                
                $resultSearch = DB::select($statement);
            }else{
                ////// table show //////////////////////////////////////////////////////////////////////
                $statement = "select BUDGET_YEAR, GPU_ID, GPU_NAME, TPU_ID, TPU_NAME, Method, ";
                $statement .= "Total_Amount,  FORMAT(Total_Amount, N'N0') as To_Total_Amount, ";
                $statement .= "cast(wavg_unit_price as decimal(10,2)) as wavg_unit_price, ";
                $statement .= "Total_Spend, FORMAT(Total_Spend, N'N0') as To_Total_Spend, ";
                $statement .= "cast(PAC_value as decimal(10,3)) as PAC_value ";
                $statement .= "from PAC_hos_TPU where BUDGET_YEAR = ".$year." and Method = '".$method."' and ".$GT."_NAME LIKE '".$Dname."' and DEPT_ID='".$Hid."';";
                
                $resultSearch = DB::select($statement);
            }

        }
        $send_data = array(
            'resultSearch'=>$resultSearch,
            'resultState'=>$resultState
        );
        return view('DrugHosUser', $send_data);
    }
}
