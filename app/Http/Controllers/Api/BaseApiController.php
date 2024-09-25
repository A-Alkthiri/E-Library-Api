<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
     
    public function sendResponse($data, $message, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public function sendError($message, $code = 400, $errors = [])
    {
        return response()->json([
            'code' => $code,
            'data' => null,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
