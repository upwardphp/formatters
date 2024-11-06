<?php

namespace Upward\Formatters\Exceptions\Documents;

class CpfSequenceException extends InvalidDocumentException
{
    public static function make(string $value): InvalidDocumentException
    {
        return new static(
            message: 'Invalid CPF document because it has sequence [' . $value . ']',
        );
    }
}
