<?php

namespace Upward\Formatters\Exceptions\Documents;

use Exception;

class InvalidCpfException extends Exception
{
    public static function make(string $value): InvalidCpfException
    {
        return new static(
            message: 'Invalid CPF [' . $value . ']',
        );
    }
}
