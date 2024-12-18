<?php

namespace Upward\Formatters\Documents;

use Upward\Formatters\Attributes\OnlyDigits;
use Upward\Formatters\Concerns\CustomAnonymizer;
use Upward\Formatters\Concerns\CustomValidation;
use Upward\Formatters\Concerns\Evaluation;
use Upward\Formatters\Contracts\Document;
use Upward\Formatters\Exceptions\Documents\CpfSequenceException;
use Upward\Formatters\Exceptions\Documents\InvalidCpfException;
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;
use Upward\Formatters\Mask;

class CpfDocument implements Document
{
    use CustomValidation;
    use CustomAnonymizer;
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
        return (new Mask(input: $this->value, output: '###.###.###-##'))->format();
    }

    public function anonymize(): string
    {
        return static::$maskUsing ?
            (static::$maskUsing)($this) :
            (new Mask(input: $this->value, output: '###.***.***-##'))
                ->obscureUsing(text: '*')
                ->replacementUsing(replacements: '#')
                ->format();
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
