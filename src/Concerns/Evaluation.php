<?php

namespace Upward\Formatters\Concerns;

trait Evaluation
{
    protected function evaluate(mixed $modifier, mixed ... $parameters): mixed
    {
        return is_null($modifier)
            ? $modifier
            : $modifier(... $parameters);
    }
}
