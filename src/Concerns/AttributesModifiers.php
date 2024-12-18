<?php

namespace Upward\Formatters\Concerns;

use ReflectionClass;
use Upward\Formatters\Contracts\Document;
use Upward\Formatters\Support\SanitizationAttributeResolver;

trait AttributesModifiers
{
    private function inspect(Document $document): void
    {
        $reflector = new ReflectionClass($document);

        SanitizationAttributeResolver::using($reflector, object: $document);
    }
}
