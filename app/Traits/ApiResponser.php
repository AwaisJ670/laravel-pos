<?php

namespace App\Traits;

/**
 *
 */
trait ApiResponser
{
    protected function successResponse($data, $message = null, $code = 200 , $token = null)
    {
        return response()->json(['status' => 'Success', 'message' => $message, 'data' => $data , 'token' => $token], $code);
    }

    protected function errorResponse($message = null, $code)
    {
        return response()->json(['status' => 'Error', 'message' => $message, 'data' => null], $code);
    }
}
