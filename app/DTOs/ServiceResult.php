<?php

namespace App\DTOs;

class ServiceResult
{
    public function __construct(
        public bool $success,
        public string $message,
        public mixed $data = [],
        public int $status = 200
    ) {}

    /** ✅ Success shortcut */
    public static function success(
        string $message = 'Success',
        mixed $data = [],
        int $status = 200
    ): self {
        return new self(true, $message, $data, $status);
    }

    /** ❌ Error shortcut */
    public static function error(
        string $message = 'Error',
        mixed $data = [],
        int $status = 400
    ): self {
        return new self(false, $message, $data, $status);
    }
}
