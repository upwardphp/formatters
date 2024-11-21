<?php

namespace Upward\Formatters\Contracts;

use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;

interface Document
{
    /**
     * Returns the raw value of the document.
     *
     * This method should return the original, unformatted, or anonymized value of the document.
     *
     * @return mixed The raw document value.
     */
    public function value(): mixed;

    /**
     * Validates the document.
     *
     * This method should check if the document is valid
     * according to the specific rules for the document type.
     *
     * @throws InvalidDocumentException If the document is invalid.
     * @return void
     */
    public function validate(): void;

    /**
     * Formats the document.
     *
     * This method should return the document in a standardized format,
     * such as adding dots and dashes to CPF or CNPJ numbers.
     *
     * @return string The formatted document.
     */
    public function format(): string;

    /**
     * Anonymizes the document.
     *
     * This method should return a partially masked version of the document
     * for privacy purposes, e.g., "123.***.***-45" for a CPF.
     *
     * @return string The anonymized document.
     */
    public function anonymize(): string;
}
