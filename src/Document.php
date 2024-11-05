<?php

namespace Upward\Formatters;

use Upward\Formatters\Documents\CpfDocument;

class Document
{
    public function cpf(string $document): CpfDocument
    {
        return new CpfDocument($document);
    }
}
