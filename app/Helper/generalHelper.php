<?php
namespace App\Helper;

if (!function_exists('generateOtp')) {
    function generateOtp(int $length = 6): string
    {
        return str_pad(strval(random_int(0, pow(10, $length) - 1)), $length, '0', STR_PAD_LEFT);
    }
}

if(!function_exists('apiResponse')){
    function apiResponse($status=null,$data=null,$message=null){
        $array=[
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ];
        return response($array,$status);
    }
}


