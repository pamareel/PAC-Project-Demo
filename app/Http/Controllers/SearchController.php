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
            // dump($_GET);
            // echo "<p>Your drug name is <b>" . $Dname . "</b>.</p>";       
        }
        $statement = "select * from Gini_drugs_".$GT." where BUDGET_YEAR = ".$year." and Method = '".$method."';";
        $resultSearch = DB::select($statement);
        // print($statement);
        // dump($resultSearch);
        // print(count($resultSearch));
        if(empty($resultSearch))
        {
            $resultSearch = 'No value';
        }
        // dump($resultSearch);
        return view('DrugPage', [ 'resultSearch' => $resultSearch ] );
    }
}
