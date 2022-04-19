<?php

namespace App\Http\Controllers;
use App\Services\VTPassService;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return void
     */
    public function index()
    {
        $vtpass = new VtPassService();
//        $response = $vtpass->getBalance();
//        $response = $vtpass->availableService();
//        $response = $vtpass->serviceID('data');
//        $response = $vtpass->variationCode('gotv');
//        $response = $vtpass->productOption('aero','passenger_type');
//        $response = $vtpass->requestID();
//        $response = $vtpass->buyAirtime('etisalat','1000','08011111111');
//        $response = $vtpass->buyData('mtn-data','09039912263','1000','mtn-10mb-100');
//        $response = $vtpass->verifySmartCardNo('dstv','1212121212');
//        $response = $vtpass->buyTvSub('gotv','1212121212','gotv-lite','0903399933','renew');
//        $response = $vtpass->verifyMetreNo('ikeja-electric','1010101010101','postpaid');
          $response = $vtpass->buyElectricity('ikeja-electric','1111111','prepaid','09033992233','20000');

        dd($response);

    }
}
