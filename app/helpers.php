<?php

if (!function_exists('successResponse')) {
    function successResponse($message, $data = null, $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
        ]);
    }
}


if (!function_exists('queryErrorResponse')) {
    function queryErrorResponse($message = 'Failed to execute query', $error = null, $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'status' => $statusCode,
            'message' => $message,
            'error' => $error,
        ]);
    }
}

if (!function_exists('serverErrorResponse')) {
    function serverErrorResponse($message = 'An unexpected server error occurred', $error = null, $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'status' => $statusCode,
            'message' => $message,
            'error' => $error,
        ]);
    }
}



if (!function_exists('validationErrorResponse')) {
    function validationErrorResponse($errors, $message = 'Validation failed', $statusCode = 422)
    {
        return response()->json([
            'success' => false,
            'status' => $statusCode,
            'message' => $message,
            'errors' => $errors,
        ]);
    }
}



if (!function_exists('createdResponse')) {
    function createdResponse(string $message = null, int $code = 201)
    {
        return response()->json([
            'success' => true,
            'status' => $code,
            'message' => $message,
            'data' => null
        ], $code);
    }
}



if (!function_exists('errorResponse')) {
    function errorResponse($message, $statusCode = 500, $error = null)
    {
        return response()->json([
            'success' => false,
            'status' => $statusCode,
            'message' => $message,
            'error' => $error,
        ]);
    }
}


if (!function_exists('updatedResponse')) {
    function updatedResponse($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'status' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}


if (!function_exists('deleteResponse')) {
    function deleteResponse(string $message = null, int $code = 204)
    {
        return response()->json([
            'success' => true,
            'status' => $code,
            'message' => $message,
        ], $code);
    }
}


if (!function_exists('notFoundResponse')) {
    function notFoundResponse($message = 'Resource not found', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'status' => $statusCode,
            'message' => $message,
            'data' => []
        ], $statusCode);
    }
}
