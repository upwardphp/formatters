<?php

namespace Upward\Formatters\Exceptions\Documents;

class InvalidCnpjException extends InvalidDocumentException
{
    public static function make(string $value): InvalidCnpjException
    {
        return new static(
            message: 'Invalid CNPJ [' . $value . ']',
        );
    }
}
