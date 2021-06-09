<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => __(str_replace(' ', '_', $exception->getMessage())),
            'errors' => $exception->errors(),
        ], $exception->status, [], JSON_UNESCAPED_UNICODE);
    }
//
//    /**
//     * Convert the given exception to an array.
//     *
//     * @param  \Throwable  $e
//     * @return array
//     */
//    protected function convertExceptionToArray(Throwable $e)
//    {
//        return config('app.debug') ? [
//            'message' => __(str_replace(' ', '_', $e->getMessage())),
//            'exception' => get_class($e),
//            'file' => $e->getFile(),
//            'line' => $e->getLine(),
//            'trace' => collect($e->getTrace())->map(function ($trace) {
//                return Arr::except($trace, ['args']);
//            })->all(),
//        ] : [
//            'message' => $this->isHttpException($e) ? $e->getMessage() : 'Server Error',
//        ];
//    }
}
