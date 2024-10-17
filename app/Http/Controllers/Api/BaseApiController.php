<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helper\ResponseHelper;

class BaseApiController extends Controller
{
    public function sendResponse($result, $message)
    {
        return ResponseHelper::sendResponse($result, $message);
    }
    
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        return ResponseHelper::sendError($error, $errorMessages, $code);
    }
}
