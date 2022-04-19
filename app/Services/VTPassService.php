<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class VTPassService
{
    /**
     * @var Repository|Application|mixed
     */
    private $username;
    /**
     * @var Repository|Application|mixed
     */
    private $url;
    /**
     * @var Repository|Application|mixed
     */
    private $password;

    public function __construct()
    {
        $mode = config('vtpass.mode', 'sandbox');
        $this->url = config('vtpass.'.$mode);
        $this->username = config('vtpass.username');
        $this->password = config('vtpass.password');

    }
//Basic authentication
    public function connection($type, $url, $param =[])
    {
        $url = $this->url.$url;
        return Http::withBasicAuth($this->username,$this->password)
            ->$type($url,$param)->json();
    }

    //General API's
    public function requestID()
    {
        $random = Str::random('10');
        return Carbon::now('Africa/Lagos')->format('YmdHi').'-'.$random;
    }
    public function getBalance()
    {
        return $this->connection('get','balance');
    }
    public function availableService()
    {
        return $this->connection('get','service-categories');
    }

    public function serviceID($identifier)
    {
        $param =[
            'identifier'=> $identifier
        ];
        return $this->connection('get','services',$param);
    }
    public function variationCode($serviceID)
    {
        $param =[
            'serviceID'=> $serviceID
        ];
        return $this->connection('get','service-variations',$param);
    }
    public function productOption($serviceID,$name)
    {
        $param =[
            'serviceID'=> $serviceID,
            'name'=> $name
        ];
        return $this->connection('get','options',$param);
    }

    //Get Airtime
    public function buyAirtime($airtimeName,$amount,$phone)
    {
        $param =[
            'serviceID'=> $airtimeName,
            'amount'=> $amount,
            'phone'=> $phone,
            'request_id'=>$this->requestID(),
        ];
        return $this->connection('post','pay',$param);
    }

    //Get Data
    public function buyData($dataName,$phone,$billersCode, $variation_code)
    {
        $param =[
            'serviceID'=> $dataName,
            'phone'=> $phone,
            'billersCode' =>$billersCode,
            'variation_code'=>$variation_code,
            'request_id'=>$this->requestID(),
        ];
        return $this->connection('post','pay',$param);
    }

    public function verifySmartCardNo($serviceID,$billersCode)
    {
        $param =[
            'serviceID'=> $serviceID,
            'billersCode'=> $billersCode
        ];
        return $this->connection('post','merchant-verify',$param);
    }
    //Get TV subscription
    public function buyTvSub($serviceID,$billersCode,$variation_code,$phone,$subscription_type)
    {
        $param =[
            'serviceID'=> $serviceID,
            'billersCode'=> $billersCode,
            'phone'=> $phone,
            'subscription_type'=>$subscription_type,
            'request_id'=>$this->requestID(),
            'variation_code'=>$variation_code,
        ];
        return $this->connection('post','pay',$param);
    }

    public function verifyMetreNo($serviceID,$billersCode,$type)
    {
        $param =[
            'serviceID'=> $serviceID,
            'billersCode'=> $billersCode,
            'type'=>$type
        ];
        return $this->connection('post','merchant-verify',$param);
    }

    //Get electricity

    public function buyElectricity($serviceID,$billersCode,$variation_code,$phone,$amount)
    {
        $param =[
            'serviceID'=> $serviceID,
            'billersCode'=> $billersCode,
            'phone'=>(int)$phone,
            'amount'=>(int)$amount,
            'request_id'=>$this->requestID(),
            'variation_code'=>$variation_code,
        ];
        return $this->connection('post','pay',$param);
    }

}
