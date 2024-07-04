<?php

namespace App\Services;

use App\Classes\ServiceResponse;

/**
 * Class BaseService
 *
 * This class provides a base service with common functionality.
 */
class BaseService
{
    /**
     * Prepare the service result.
     *
     * @param mixed $data The data to be returned.
     * @param bool $status The status of the response.
     * @param string|null $message The message of the response.
     * @param int|null $errorCode The error code of the response.
     * @return ServiceResponse The prepared service response.
     */
    protected function prepareResult($data, bool $status = true, string $message = null, ?int $errorCode = null): ServiceResponse
    {
        return new ServiceResponse($data, $status, $message, $errorCode);
    }
}
