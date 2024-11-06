<?php

namespace Upward\Formatters\Exceptions\Documents;

use Exception;

class InvalidDocumentException extends Exception
{
    public static function make(string $value): InvalidDocumentException
    {
        return new static(
            message: 'Invalid document [' . $value . ']',
        );
    }
}
