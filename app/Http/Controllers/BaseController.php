<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($message=null, $result, $statusCode){
        $response = [
            'status'=>true,
            'message'=>$message,
            'data'=>$result
        ];
        return response()->json($response,$statusCode);
    }

    public function sendError($statusCode, $message = null, $errors = []){
        $response = [
            'status'=>false,
            'message'=> $message,
            'errors'=>$errors
        ];
        return response()->json($response,$statusCode);
    }
}
