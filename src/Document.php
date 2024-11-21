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

    public function value(): mixed
    {
        return $this->document->value();
    }

    public function validate(): void
    {
        $this->document->validate();
    }

    public function format(): string
    {
        return $this->document->format();
    }

    public function anonymize(): string
    {
        return $this->document->anonymize();
    }
}
