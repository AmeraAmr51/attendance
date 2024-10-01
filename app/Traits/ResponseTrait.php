<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * A trait for sending success and error responses in JSON format.
 */
trait ResponseTrait
{
    /**
     * Send a success response in JSON format.
     *
     * @param mixed $data The data to be included in the response.
     * @param string|null $message The message to be included in the response.
     * @param int $code The HTTP status code to be used in the response.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function sendSuccess($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Send an error response in JSON format.
     *
     * @param mixed $errors The errors to be included in the response.
     * @param string|null $message The message to be included in the response.
     * @param int $code The HTTP status code to be used in the response.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function sendError($errors, $message = null, $code = 400, $throw = false)
    {
        if($throw)
        {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => $message,
                'errors' => $errors
            ], $code));
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => $message,
                'errors' => $errors
            ], $code);
        }
    }

    
}
