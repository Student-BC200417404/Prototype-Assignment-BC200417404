<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ErrorLog;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Generic function for success messages
    public function success($message, $data = null, $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    // Generic function for error messages
    public function error($message, $statusCode = 400, $data = null)
    {
        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    // Function to log errors
    public function logError(\Exception $exception, Request $request)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Get the stack trace from the exception
        $stackTrace = $exception->getTraceAsString();

        // Additional data can be an array of relevant information
        $additionalData = [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
        ];

        // Create the error log entry
        ErrorLog::create([
            'method' => request()->method() , // Ensure this key is in the $fillable array
            'user_id' => $userId, // Assuming you have the user ID
            'error_code' => '404',
            'error_message' => $exception->getMessage(),
            'stack_trace' => $stackTrace, // Assuming you have the stack trace
            'additional_data' => json_encode($additionalData), // Any extra data
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->url(),
            'request_method' => request()->method(),
        ]);
    }
}
