<?php

namespace Upward\Formatters;

use Upward\Formatters\Concerns\AttributesModifiers;
use Upward\Formatters\Contracts\Document as DocumentInterface;

class Document
{
    use AttributesModifiers;

    public function __construct(
        public readonly DocumentInterface $document,
    )
    {
        $this->inspect($this->document);
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
