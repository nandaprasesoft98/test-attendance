<?php

namespace App\Helper;

class ResponseHelper
{
    public static function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    
    public static function sendError($errorMessage, $errorData = [], $code = 404)
    {
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $errorMessage,
        ];
        if (!empty($errorData)) {
            $response['data'] = $errorData;
        }
        return response()->json($response, $code);
    }
}
