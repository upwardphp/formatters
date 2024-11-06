<?php

namespace Upward\Formatters;

use Upward\Formatters\Contracts\Document as DocumentInterface;

class Document
{
    public function __construct(
        private readonly DocumentInterface $document,
    )
    {
    }

    public function validate(): void
    {
        $this->document->validate();
    }

    public function format(): string
    {
        return $this->document->format();
    }

    public function sanitize(): string
    {
        return $this->document->sanitize();
    }
}
