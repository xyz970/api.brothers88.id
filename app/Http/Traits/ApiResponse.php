<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Validation\ValidationException;

trait ApiResponse
{
    private function RespondError($message, int $statusCode = 400, Exception $exception = null, int $error_code = 1)
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message ?? "Oops, Something wrong",
                'exception' => $exception,
                'error_code' => $error_code
            ],
            $statusCode
        );
    }
    protected function successResponse($message, $data,$status = 200)
    {
        return response()->json(
            [
                "success" => true,
                "message" => $message,
                "data" => $data
            ],
            $status
        );
    }


    protected function emptyResponse($message, $status = 200)
    {
        return response()->json(
            [
                "success" => true,
                "message" => $message,
            ],
            $status
        );
    }


    protected function internalErrorResponse($message, $status = 500)
    {
        return $this->RespondError($message, $status);
    }

    protected function notFoundResponse($message = "Oops. Request not found", $status = 404)
    {
        return $this->RespondError($message, $status);
    }

    protected function unauthorizedResponse($message = "Oops. You cannot access the data", $status = 401)
    {
        return $this->RespondError($message, $status);
    }
    public function validationErrorResponse(ValidationException $ex)
    {
        return response()->json(
            [
                "success" => false,
                "message" => $ex->getMessage(),
                "errors" => $ex->errors(),
            ],
            422
        );
    }

}
