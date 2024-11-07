# Upward Formatters

`Upward Formatters` is a PHP package that provides utilities for formatting, validating, and anonymizing documents such as CPF, CNPJ, numbers, and dates. It implements PSR-4 for autoloading and can be easily integrated into any PHP project.

## Features

- **Validation:** Checks if a document (such as CPF or CNPJ) is in the correct format and is valid.
- **Formatting:** Applies standard masks and formats to documents.
- **Anonymization:** Offers the option to anonymize documents by replacing part of the value with masked characters.
- **Extendable:** The package is easily extendable to include new document types or other formats (numbers, dates, etc.).

## Installation

To install the package, use Composer:

```bash
composer require upward/formatters
```

## Document usage
### CPF Document

The CpfDocument class is a specific implementation of the Document interface designed to handle Brazilian CPF (Cadastro de Pessoas Físicas) numbers. It provides methods for validating, formatting, and anonymizing CPF values.

#### Examples
##### Validating a CPF Document
In this example, we demonstrate how to use the CpfDocument class to validate a CPF number. The CpfDocument class provides a method to validate a CPF, ensuring that it follows the correct format and is valid according to the CPF checksum algorithm. If the CPF is invalid, an exception will be thrown, allowing you to handle it appropriately.

```php

use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Document;

$cpf = new CpfDocument(value: '12345678909');
$document = new Document($cpf);

try {
    $document->validate(); // throw an exception if invalid
} catch (\Exception) {
    // Handle invalid CPF Document
}
```
##### Formatting and Anonymizing a CPF Document
This example demonstrates how to use the CpfDocument class to format and anonymize a CPF number. The format() method applies a standard CPF mask (e.g., `###.###.###-##`), while the anonymize() method obscures part of the CPF for privacy purposes (e.g., `123.***.***-09`).

```php
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Document;

$cpf = new CpfDocument(value: '12345678909');
$document = new Document($cpf);

$document->format(); // 123.456.789-09

$document->anonymize(); // 123.***.***-09

```
