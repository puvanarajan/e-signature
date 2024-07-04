<?php

namespace App\Http\Controllers;

use App\Enums\ErrorCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

/**
 * Class Controller
 *
 * This base controller provides common response methods.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Send a success response.
     *
     * @param mixed|null $data The optional data to include in the response.
     * @param string|null $message The success message (default: 'success').
     * @param int $statusCode The HTTP status code (default: 200 OK).
     * @return JsonResponse
     */
    protected function sendSuccessResponse(
        $data = null,
        $message = 'success',
        int $statusCode = JsonResponse::HTTP_OK
    ): JsonResponse
    {
        return $this->sendJsonResponse($data, true, $message, $statusCode);
    }

    /**
     * Send an error response.
     *
     * @param string|null $message The error message.
     * @param mixed|null $data The optional data to include in the response.
     * @param int $statusCode The HTTP status code (default: 400 Bad Request).
     * @param int|null $errorCode The optional custom error code.
     * @return JsonResponse
     */
    protected function sendErrorResponse(
        $data = null,
        string $message = null,
        int $statusCode = JsonResponse::HTTP_BAD_REQUEST,
        int $errorCode = null
    ): JsonResponse
    {
        return $this->sendJsonResponse($data, false, $message, $statusCode, $errorCode);
    }

    /**
     * Send an unauthenticated response.
     *
     * @param string|null $message The unauthenticated message (default: 'Unauthenticated').
     * @param mixed|null $data The optional data to include in the response.
     * @param int $statusCode The HTTP status code (default: 401 Unauthorized).
     * @param int $errorCode The custom error code (default: ErrorCode::UNAUTHORIZED->value).
     * @return JsonResponse
     */
    protected function sendUnauthenticatedResponse(
        string $message = 'Unauthenticated',
               $data = null,
        int    $statusCode = JsonResponse::HTTP_UNAUTHORIZED,
        int    $errorCode = ErrorCode::UNAUTHORIZED->value
    ): JsonResponse
    {
        return $this->sendJsonResponse($data, false, $message, $statusCode, $errorCode);
    }


    /**
     * Send a JSON response.
     *
     * @param mixed|null $data The data to include in the response.
     * @param bool $status The status of the response.
     * @param string $message The response message.
     * @param int $statusCode The HTTP status code.
     * @param int|null $errorCode The optional custom error code.
     * @param JsonResource|null $resource The optional resource for transforming the data.
     * @return JsonResponse
     */
    protected function sendJsonResponse(
        $data = null,
        bool $status = true,
        $message = 'success',
        int $statusCode = JsonResponse::HTTP_OK,
        $errorCode = null,
        $resource = null
    ): JsonResponse
    {

        $response = ['success' => $status];
        $response['message'] = $message;

        if (!is_null($errorCode)) {
            $response['error_code'] = $errorCode;
        }
        if (!is_null($data)) {
            if ($data instanceof LengthAwarePaginator) {

                if ($resource instanceof JsonResource) {
                    $response['data'] = $resource::collection($data->items());
                } else {
                    $response['data'] = $data->items();
                }

                $response['per_page'] = $data->perPage();
                $response['total'] = $data->total();
                $response['last_page'] = $data->lastPage();
                $response['current_page'] = $data->currentPage();
            } else {
                $response['data'] = $data;
            }
        }

        return Response::json($response, $statusCode);
    }
}
