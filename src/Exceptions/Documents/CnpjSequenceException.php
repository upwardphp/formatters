<?php

namespace Upward\Formatters\Exceptions\Documents;

class CnpjSequenceException extends InvalidDocumentException
{
    public static function make(string $value): CnpjSequenceException
    {
        return new static(
            message: 'Invalid CNPJ document because it has sequence [' . $value . ']'
        );
    }
}
