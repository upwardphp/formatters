<?php

namespace Upward\Formatters\Exceptions\Documents;

class InvalidCpfException extends InvalidDocumentException
{
    public static function make(string $value): InvalidCpfException
    {
        return new static(
            message: 'Invalid CPF [' . $value . ']',
        );
    }
}
