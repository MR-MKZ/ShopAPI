<?php

namespace App\Classes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
class ApiResponseClass
{
    public static function rollback($e, $message ="Something went wrong! Process not completed"){
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message ="Something went wrong! Process not completed"){
        Log::info($e);
        throw new HttpResponseException(response()->json(["message"=> $message], 500));
    }

    public static function sendError($message="Something went wrong!", $code=500){
        $response = [
            "success" => false,
            "message" => $message
        ];

        return response()->json($response, $code);
    }

    public static function sendResponse($result, $message ,$code=200, $status=true){
        $response = [
            'success' => $status,
            'data'    => $result
        ];

        if(!empty($message)){
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

}
