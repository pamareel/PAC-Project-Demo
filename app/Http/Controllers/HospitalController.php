<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HospitalController extends Controller
{
    public function index(){
        $Region_1_name = ["TH-50"=>"Chiang Mai","TH-57"=>"Chiang Rai","TH-51"=>"Lamphun","TH-52"=>"Lampang","TH-54"=>"Phrae","TH-55"=>"Nan","TH-56"=>"Phayao","TH-58"=>"Mae Hong Son"];
        $Region_2_name = ['TH-65'=>'Phitsanulok','TH-67'=>'Phetchabun','TH-53'=>'Uttaradit','TH-63'=>'Tak','TH-64'=>'Sukhothai'];
        $Region_3_name = ['TH-60'=>'Nakhon Sawan','TH-62'=>'Kamphaeng Phet','TH-66'=>'Phichit','TH-61'=>'Uthai Thani','TH-18'=>'Chai Nat'];
        $Region_4_name = ['TH-17'=>'Sing Buri','TH-16'=>'Lop Buri','TH-19'=>'Saraburi','TH-12'=>'Nonthaburi','TH-14'=>'Phra Nakhon Si Ayutthaya','TH-15'=>'Ang Thong','TH-13'=>'Pathum Thani','TH-26'=>'Nakhon Nayok'];
        $Region_5_name = ['TH-70'=>'Ratchaburi','TH-72'=>'Suphan Buri','TH-73'=>'Nakhon Pathom','TH-71'=>'Kanchanaburi','TH-75'=>'Samut Songkhram','TH-74'=>'Samut Sakhon','TH-76'=>'Phetchaburi','TH-77'=>'Prachuap Khiri Khan'];
        $Region_6_name = ['TH-20'=>'Chon Buri','TH-21'=>'Rayong','TH-22'=>'Chanthaburi','TH-23'=>'Trat','TH-11'=>'Samut Prakan','TH-24'=>'Chachoengsao','TH-25'=>'Prachin Buri','TH-27'=>'Sa Kaeo'];
        $Region_7_name = ['TH-40'=>'Khon Kaen','TH-44'=>'Maha Sarakham','TH-45'=>'Roi Et','TH-46'=>'Kalasin'];
        $Region_8_name = ['TH-41'=>'Udon Thani','TH-47'=>'Sakon Nakhon','TH-48'=>'Nakhon Phanom','TH-42'=>'Loei','TH-39'=>'Nong Bua Lam Phu','TH-43'=>'Nong Khai']; //+'บึงกาฬ'
        $Region_9_name = ['TH-30'=>'Nakhon Ratchasima','TH-36'=>'Chaiyaphum','TH-31'=>'Buri Ram','TH-32'=>'Surin'];
        $Region_10_name = ['TH-34'=>'Ubon Ratchathani','TH-33'=>'Si Sa Ket','TH-35'=>'Yasothon','TH-37'=>'Amnat Charoen','TH-49'=>'Mukdahan'];
        $Region_11_name = ['TH-86'=>'Chumphon','TH-85'=>'Ranong','TH-84'=>'Surat Thani','TH-80'=>'Nakhon Si Thammarat','TH-82'=>'Phangnga','TH-81'=>'Krabi','TH-83'=>'Phuket'];
        $Region_12_name = ['TH-96'=>'Narathiwat','TH-94'=>'Pattani','TH-95'=>'Yala','TH-90'=>'Songkhla','TH-91'=>'Satun','TH-93'=>'Phatthalung','TH-92'=>'Trang'];
        $Region_13_name = ['TH-10'=>'Bangkok Metropolis'];

        if (!empty($_GET)){
            $year = $_GET['year'];
            $region = $_GET['region'];
            $province = $_GET['province'];
            $type = $_GET['type'];
            $Hname= $_GET['Hname'];
            $resultState = "".$year.", Region ".$region.", ".$province.", Type ".$type.", ".$Hname."";
            $statement = '';
            if($region == 'All'){
                ////// table show //////////////////////////////////////////////////////////////////////
                $statement .= "select DEPT_ID, DEPT_NAME, ServicePlanType, PROVINCE_EN, Region, FORMAT(IP, N'N0') as IP, FORMAT(OP, N'N0') as OP, CONVERT(varchar, CAST(Total_Spend as money), 1) as Total_Spend from Hos_detail where BUDGET_YEAR = ".$year." ";
            }else{
                ////// table show //////////////////////////////////////////////////////////////////////
                $statement .= "select DEPT_ID, DEPT_NAME, ServicePlanType, PROVINCE_EN, Region, FORMAT(IP, N'N0') as IP, FORMAT(OP, N'N0') as OP, CONVERT(varchar, CAST(Total_Spend as money), 1) as Total_Spend from Hos_detail where BUDGET_YEAR = ".$year." and Region = '".$region."' ";
            }
            if($province != 'All'){
                $statement .= "and PROVINCE_EN ='".$province."' ";
            }
            if($type != 'All'){
                $statement .= "and ServicePlanType = '".$type."' ";
            }
            if($Hname != null){
                $statement .= "and DEPT_NAME = '".$Hname."'";
            }
            $resultSearch = DB::select($statement);
        }
        if(empty($resultSearch)){
            $resultSearch = 'No value';
            $resultState = 'Please select again';

        }
        $send_data = array(
            'resultSearch'=>$resultSearch, 'resultState'=>$resultState
        );
        return view('HospitalPage', $send_data);
    }
}
