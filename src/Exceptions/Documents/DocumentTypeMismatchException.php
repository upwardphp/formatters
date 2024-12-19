<?php

namespace Upward\Formatters\Exceptions\Documents;

use Exception;

class DocumentTypeMismatchException extends Exception
{
    public static function make(): DocumentTypeMismatchException
    {
        return new static(
            message: 'The provided array contains invalid document instances.',
        );
    }
}
