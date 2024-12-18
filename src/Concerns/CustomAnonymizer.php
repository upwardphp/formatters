<?php

namespace Upward\Formatters\Concerns;

use Closure;

trait CustomAnonymizer
{
    public static Closure | null $maskUsing = null;

    public function modifyMaskUsing(Closure $callback): static
    {
        static::$maskUsing = $callback;
        return $this;
    }
}
