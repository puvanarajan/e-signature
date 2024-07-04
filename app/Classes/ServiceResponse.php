<?php

namespace App\Classes;

/**
 * Class ServiceResponse
 *
 * This class standardizes the structure of responses throughout the application.
 */
class ServiceResponse
{
    /**
     * @var bool Indicates the status of the response.
     */
    public bool $status;

    /**
     * @var string|null The message associated with the response.
     */
    public ?string $message;

    /**
     * @var mixed The data payload of the response.
     */
    public $data;

    /**
     * @var int|null The error code, if any.
     */
    public ?int $errorCode;

    /**
     * ServiceResponse constructor.
     *
     * @param mixed $data The data payload of the response.
     * @param bool $status Indicates the status of the response.
     * @param string|null $message The message associated with the response.
     * @param int|null $errorCode The error code, if any.
     */
    public function __construct($data, bool $status = true, ?string $message = null, ?int $errorCode = null)
    {
        $this->data = $data;
        $this->status = $status;
        $this->message = $message;
        $this->errorCode = $errorCode;
    }
}
