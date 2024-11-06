<?php

namespace Upward\Formatters\Documents;

use Upward\Formatters\Contracts\Document;
use Upward\Formatters\Exceptions\Documents\CpfSequenceException;
use Upward\Formatters\Exceptions\Documents\InvalidCpfException;
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;

class CpfDocument implements Document
{
    public function __construct(
        private readonly string $value,
    )
    {
    }

    public function validate(): void
    {
        // Extract only numbers
        $digits = $this->onlyDigits($this->value);

        // Has all digits
        if (strlen($digits) != 11) {
            throw InvalidDocumentException::make(value: $digits);
        }

        // Has sequence. Ex: 111.111.111-11
        if ($this->hasSequenceIn(value: $digits)) {
            throw CpfSequenceException::make(value: $digits);
        }

        // calc to verify CPF
        if (!$this->verify($digits)) {
            throw InvalidCpfException::make(value: $digits);
        }
    }

    public function format(): string
    {
        $digits = $this->onlyDigits($this->value);

        // Apply the CPF mask
        return preg_replace(
            pattern: '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            replacement: '$1.$2.$3-$4',
            subject: $digits,
        );
    }

    public function sanitize(): string
    {
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
}
