<?php

declare(strict_types=1);

namespace App\Modules\Shared\Exceptions;

final class EnumNotSupported extends \Exception
{
    public function __construct(string $enum, ?string $name, int $code = 400, \Throwable $previous = null)
    {
        $message = "Unknown $enum with type: $name";

        parent::__construct($message, $code, $previous);
    }
}
