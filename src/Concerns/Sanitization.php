<?php

namespace Upward\Formatters\Concerns;

use function Upward\Formatters\Helpers\Sanitization\only_digits;

trait Sanitization
{
    protected function onlyDigits(string $value): string
    {
        return only_digits($value);
    }
}
