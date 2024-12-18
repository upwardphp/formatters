### CNPJ Document

The `CnpjDocument` class is a specific implementation of the `Document` interface, designed to handle Brazilian CNPJ (Cadastro Nacional da Pessoa Jurídica) numbers. It provides methods for validating, formatting, and anonymizing CNPJ values.

#### Examples
##### Validating a CNPJ Document
In this example, we demonstrate how to use the `CnpjDocument` class to validate a CNPJ number. The `CnpjDocument` class provides a method to validate a CNPJ, ensuring it follows the correct format and is valid according to the CNPJ checksum algorithm. If the CNPJ is invalid, an exception will be thrown, allowing you to handle it appropriately.

```php
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Document;

$cnpj = new CnpjDocument(value: '12345678000195');
$document = new Document($cnpj);

try {
    $document->validate(); // throws an exception if invalid
} catch (\Exception) {
    // Handle invalid CNPJ Document
}
```

#### Get the Document Value
Retrieve the document's raw or formatted value using the `value()` method:

```php
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Document;

$cnpj = new CnpjDocument(value: '12345678000195');
$document = new Document($cnpj);

echo $document->value(); // Outputs: 12345678000195
```

##### Formatting and Anonymizing a CNPJ Document
This example demonstrates how to use the `CnpjDocument` class to format and anonymize a CNPJ number. The `format()` method applies a standard CNPJ mask (e.g., `##.###.###/####-##`), while the `anonymize()` method obscures part of the CNPJ for privacy purposes (e.g., `12.345.678/****-09`).

```php
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Document;

$cnpj = new CnpjDocument(value: '12345678000195');
$document = new Document($cnpj);

$document->format(); // 12.345.678/0001-95

$document->anonymize(); // 12.***.***/0001-95
```

#### Customize Validation Logic
You can define custom validation logic for a document using the `modifyValidateUsing` method. This allows you to adapt validation without extending classes:

```php
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Document;

$cnpj = new CnpjDocument('12345678000195');

// Define custom validation logic
$cnpj->modifyValidateUsing(function (CnpjDocument $document): void {
    if (strlen($document->value()) !== 14) {
        throw new \InvalidArgumentException('Invalid CNPJ length.');
    }
});

$cnpj->validate(); // Executes the custom validation logic
```

#### Global Validation Logic
If you need to define a global validation logic that applies to all instances of a document class, you can use the static `$validateUsing` property. This allows you to standardize validation across your application:

```php
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Document;

CnpjDocument::$validateUsing = function (CnpjDocument $document): void {
    if (strlen($document->value()) !== 14) {
        throw new \InvalidArgumentException('Invalid CNPJ length.');
    }

    if (!ctype_digit($document->value())) {
        throw new \InvalidArgumentException('CNPJ must contain only numbers.');
    }
};
```

#### Modify Document Mask
Use `modifyMaskUsing` to apply custom formatting or masking to the document value. This feature allows you to modify the format of the document based on a callback function:

```php
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Document;
use Upward\Formatters\Mask;

$cnpj = new CnpjDocument('12345678000195');

// Modify the mask of the document
$cnpj->modifyMaskUsing(callback: static function (CnpjDocument $document): string {
    return (new Mask(input: $document->value(), output: '***.###.###/****-**'))->format();
});

$document = new Document($cnpj);

echo $document->anonymize(); // Outputs: ***.456.789/****-**
```

---
