<?php

namespace Upward\Formatters\Documents;

use Closure;
use Upward\Formatters\Contracts\Document;
use Upward\Formatters\Exceptions\Documents\CpfSequenceException;
use Upward\Formatters\Exceptions\Documents\InvalidCpfException;
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;
use Upward\Formatters\Mask;

class CpfDocument implements Document
{
    public static Closure|null $validateUsing = null;

    public function __construct(
        private string $value,
    )
    {
        $this->value = $this->onlyDigits(value: $this->value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function validate(): void
    {
        if (static::$validateUsing) {
            $callback = static::$validateUsing;
            $callback($this);
            return;
        }

        // Has all digits
        if (strlen($this->value) != 11) {
            throw InvalidDocumentException::make(value: $this->value);
        }

        // Has sequence. Ex: 111.111.111-11
        if ($this->hasSequenceIn(value: $this->value)) {
            throw CpfSequenceException::make(value: $this->value);
        }

        // calc to verify CPF
        if (!$this->verify($this->value)) {
            throw InvalidCpfException::make(value: $this->value);
        }
    }

    public function format(): string
    {
        $digits = $this->onlyDigits($this->value);

        return (new Mask(input: $digits, output: '###.###.###-##'))->format();
    }

    public function anonymize(): string
    {
        return (new Mask(input: $this->onlyDigits($this->value), output: '###.***.***-##'))
            ->obscureUsing(text: '*')
            ->replacementUsing(replacements: '#')
            ->format();
    }

    private function onlyDigits(string $value): string
    {
        return preg_replace(
            pattern: '/[^0-9]/is',
            replacement: '',
            subject: $value,
        );
    }

    private function hasSequenceIn(string $value): bool
    {
        return preg_match(pattern: '/(\d)\1{10}/', subject: $value);
    }

    private function verify(string $digits): bool
    {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $digits[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($digits[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public function modifyValidateUsing(Closure $callback): static
    {
        static::$validateUsing = $callback;
        return $this;
    }
}
