<?php

namespace Upward\Formatters;

use Closure;

class Mask
{
    protected string $obscureText = '*';

    protected array $replacements = ['#'];

    public function __construct(
        protected readonly string $input,
        protected readonly string $output,
    )
    {
    }

    public function format(): string
    {
        $formatted = '';
        $inputIndex = 0;

        // Loop through each character in the output format
        for ($i = 0; $i < strlen($this->output); $i++) {
            if (in_array(needle: $this->output[$i], haystack: $this->replacements)) {
                // Replace "#" with the next character from the input
                if (isset($this->input[$inputIndex])) {
                    $formatted .= $this->input[$inputIndex];
                    $inputIndex++;
                }
            } elseif ($this->output[$i] === $this->obscureText) {
                // Replace "*" with a fixed character (like an asterisk)
                $formatted .= $this->obscureText;
                $inputIndex++; // Skip to the next input character
            } else {
                // Add any other character from the output format as-is
                $formatted .= $this->output[$i];
            }
        }

        return $formatted;
    }

    public function obscureUsing(string|Closure $text): static
    {
        if (is_string($text)) {
            $this->obscureText = $text;
            return $this;
        }

        if (is_callable(value: $text) && is_string(value: $text())) {
            $this->obscureText = $text();
            return $this;
        }

        throw new \InvalidArgumentException(message: '$text cannot be different of string.');
    }

    public function replacementUsing(array|string|Closure $replacements): static
    {
        if (is_callable(value: $replacements)) {
            $replacements = $replacements();
        }

        if (is_array(value: $replacements)) {
            $this->replacements = $replacements;
            return $this;
        }

        if (is_string(value: $replacements)) {
            $this->replacements = [$replacements];
            return $this;
        }

        throw new \InvalidArgumentException(message: '$replacements cannot be different of string|array.');
    }
}
