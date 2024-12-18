<?php

namespace Upward\Formatters\Documents;

use Upward\Formatters\Attributes\OnlyDigits;
use Upward\Formatters\Concerns\CustomValidation;
use Upward\Formatters\Concerns\Evaluation;
use Upward\Formatters\Contracts\Document;
use Upward\Formatters\Exceptions\Documents\CnpjSequenceException;
use Upward\Formatters\Exceptions\Documents\InvalidCnpjException;

class CnpjDocument implements Document
{
    use CustomValidation;
    use Evaluation;

    public function __construct(
        #[OnlyDigits]
        private string $value,
    )
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function validate(): void
    {
        if (static::$validateUsing) {
            $this->evaluate(modifier: static::$validateUsing, document: $this);
            return;
        }

        $this->validateLength();
        $this->validateSequence();
        $this->validateVerifierDigit();
    }

    public function format(): string
    {
    }

    public function anonymize(): string
    {
    }

    /**
     * @throws InvalidCnpjException
     */
    private function validateLength(): void
    {
        if (strlen($this->value) != 14) {
            throw InvalidCnpjException::make($this->value);
        }
    }

    /**
     * @throws CnpjSequenceException
     */
    private function validateSequence(): void
    {
        if (preg_match('/^(\d)\1{13}$/', $this->value) === 1) {
            throw CnpjSequenceException::make($this->value);
        }
    }

    /**
     * @throws InvalidCnpjException
     */
    private function validateVerifierDigit(): void
    {
        $calculatedDigits = $this->calculateVerificationDigits();

        $actualDigits = substr($this->value, -2);

        if ($calculatedDigits != $actualDigits) {
            throw InvalidCnpjException::make($this->value);
        }
    }

    private function calculateVerificationDigits(): string
    {
        $firstDigit = $this->calculateDigit(length: 12);
        $secondDigit = $this->calculateDigit(length: 13);

        return $firstDigit . $secondDigit;
    }

    private function calculateDigit(int $length): string
    {
        $weights = $length === 12
            ? [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
            : [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $sum = 0;

        for ($i = 0; $i < $length; $i++) {
            $sum += $this->value[$i] * $weights[$i];
        }

        $remainder = $sum % 11;

        return $remainder < 2 ? '0' : (string)(11 - $remainder);
    }
}
