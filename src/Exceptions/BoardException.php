<?php

namespace App\Exceptions;

use Exception;

class BoardException extends Exception
{
    protected array $context;

    public function __construct(string $message = "", int $code = 0, array $context = [])
    {
        parent::__construct($message, $code);
        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getDetails(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'context' => $this->context
        ];
    }
}
