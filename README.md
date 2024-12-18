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

- [CPF](docs/documents/CPF.md)
- [CNPJ](docs/documents/CNPJ.md)
