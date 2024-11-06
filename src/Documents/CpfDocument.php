<?php

namespace Upward\Formatters\Documents;

use Upward\Formatters\Contracts\Document;

class CpfDocument implements Document
{
    public function __construct(
        private readonly string $value,
    )
    {
    }

    public function validate(): void
    {
    }

    public function format(): string
    {
    }

    public function sanitize(): string
    {
    }
}
