<?php

namespace Upward\Formatters\Documents;

use Upward\Formatters\Contracts\Document;

class CpfDocument implements Document
{
    public function __construct(
        public readonly string $document,
    )
    {
    }

    public function validate(): void
    {
        // TODO: Validate CPF
    }

    public function format(): string
    {
        return '';
    }

    public function sanitize(): string
    {
        return '';
    }
}
