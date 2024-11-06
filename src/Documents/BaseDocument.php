<?php

namespace Upward\Formatters\Documents;

use Upward\Formatters\Contracts\Document;

abstract class BaseDocument implements Document
{
    public function __construct(
        public readonly string $text,
    )
    {
    }
}
