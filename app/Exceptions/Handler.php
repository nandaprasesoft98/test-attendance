<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            return $this->doRender($e, $request);
        });
    }

    private function doRender(Throwable $e, Request $request)
    {
        return $this->handleApiException($e, $request);
    }

    private function handleApiException(Throwable $e, Request $request)
    {
        $exception = $this->prepareException($e);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        $isDebug = config('app.debug');
        
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        switch ($statusCode) {
            case 401:
                $message = 'Unauthorized';
                break;
            case 403:
                $message = 'Forbidden';
                break;
            case 404:
                $message = 'Not Found';
                break;
            case 405:
                $message = 'Method Not Allowed';
                break;
            case 422:
                $message = $exception->original['message'];
                $errors = $exception->original['errors'];
                break;
            default:
                $message = ($statusCode == 500) ? "Whoops, looks like something went wrong" . ($isDebug ? ": {$exception->getMessage()}" : "") : $exception->getMessage();
                break;
        }

        $errorData = [];

        if (isset($errors)) {
            $errorData["errors"] - $errors;
        }

        if ($isDebug) {
            if (method_exists($exception, "getTrace")) {
                $debugData['trace'] = $exception->getTrace();
            }
            if (method_exists($exception, "getTrace")) {
                $debugData['code'] = $exception->getCode();
            }
            if (isset($debugData)) {
                $errorData['debug_data'] = $debugData;
            }
        }

        return ResponseHelper::sendError(
            $message, $errorData, $statusCode
        );
    }
}
