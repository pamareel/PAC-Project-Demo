<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//add to link with database
use DB;

class EbiddingController extends Controller
{
    public function getEbiddingInfo()
    {
        #import code in SQL server
        $data = DB::select('EXEC getEbiddingInfo');
        //show data in website
        dump($data);
    }

    public function getEbiddingInfo15()
    {
        #import code in SQL server
        $data = DB::select('EXEC getEbiddingInfoAny ?', [15]);
        //show data in website
        dump($data);
    }

    public function getEbiddingInfoAny($id)
    {

        #import code in SQL server
        $data = DB::select('EXEC getEbiddingInfoAny ?', [$id]);
        //show data in website
        dump($data);
    }

    public function getEbiddingInfoInput(Request $request)
    {
        #import code in SQL server
        $value = [$request->Record_id];
        $data = DB::select('EXEC getEbiddingInfoAny ?', $value);
        //show data in website
        dump($data);
    }

    public function testDB()
    {
        return view('testDB');
    }
}
