<?php

namespace App\Exceptions;

use App\Enums\ErrorCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->errorResponse('Validation error',
                ErrorCode::VALIDATION_ERROR->value,
                $e->errors(),
                $e->status);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->errorResponse('Not found',
                ErrorCode::MODEL_NOT_FOUND->value,
                $e->getMessage(),
                Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(),
                ErrorCode::ACTION_UNAUTHORIZED->value,
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof InvalidSignatureException) {
            return $this->errorResponse($e->getMessage(),
                ErrorCode::INVALID_SIGNATURE->value,
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $e);
    }

    /**
     * @param $message
     * @param $errorCode
     * @param $error
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse($message, $errorCode, $error, $statusCode)
    {
        return response()
                ->json([
                    'success' => false,
                    'message' => $message,
                    'error_code' => $errorCode,
                    'data' => [],
                    'error' => $error
                ], $statusCode);
    }
}
