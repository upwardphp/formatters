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

    if (!ctype_digit($document->value())) {
        throw new \InvalidArgumentException('CPF must contain only numbers.');
    }
};
```

#### Modify Document Mask
Use `modifyMaskUsing` to apply custom formatting or masking to the document value. This feature allows you to modify the format of the document based on a callback function:

```php
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Document;
use Upward\Formatters\Mask;

$cpf = new CpfDocument('12345678901');

// Modify the mask of the document
$cpf->modifyMaskUsing(callback: static function (CpfDocument $document): string {
    return (new Mask(input: $document->value(), output: '***.###.###-**'))->format();
});

$document = new Document($cpf);

echo $document->anonymize(); // output: ***.456.789-**

```
