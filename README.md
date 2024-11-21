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
#### Get the Document Value
Retrieve the document's raw or formatted value using the `value()` method:

```php
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Document;

$cpf = new CpfDocument(value: '12345678901');
$document = new Document($cpf);

echo $document->value(); // Outputs: 12345678901
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

#### Customize Validation Logic
You can define custom validation logic for a document using the `modifyValidateUsing` method. This allows you to adapt validation without extending classes:

```php
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Document;

$cpf = new CpfDocument('12345678901');

// Define custom validation logic
$cpf->modifyValidateUsing(function (CpfDocument $document): void {
  if (strlen($document->value()) !== 11) {
    throw new \InvalidArgumentException('Invalid CPF length.');
  }
  // Add additional validation rules here
});

$cpf->validate(); // Executes the custom validation logic
```

#### Global Validation Logic
If you need to define a global validation logic that applies to all instances of a document class, you can use the static `$validateUsing` property. This allows you to standardize validation across your application:

```php
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Document;

CpfDocument::$validateUsing = function (CpfDocument $document): void {
    if (strlen($document->value()) !== 11) {
        throw new \InvalidArgumentException('Invalid CPF length.');
    }

    // Additional validation rules
    if (!ctype_digit($document->value())) {
        throw new \InvalidArgumentException('CPF must contain only numbers.');
    }
};
```
