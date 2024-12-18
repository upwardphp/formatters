<?php

namespace Upward\Formatters\Concerns;

use Closure;

trait CustomValidation
{
    public static Closure | null $validateUsing = null;

    public function modifyValidateUsing(Closure $callback): static
    {
        static::$validateUsing = $callback;
        return $this;
    }
}
