[![Latest Stable Version](https://poser.pugx.org/chokri/pdfkit/v/stable.svg)](https://packagist.org/packages/chokri/pdfkit)
[![License](https://poser.pugx.org/chokri/pdfkit/license.svg)](https://packagist.org/packages/chokri/pdfkit)

# PDFKit

A simple PHP library for making PDF files. Uses [setasign/fpdf](https://github.com/Setasign/FPDF) and works with PHP 8.4 or newer.

## Installation

Install with Composer:

```bash
composer require chokri/pdfkit
```

## Basic Example

```php
require 'vendor/autoload.php';

use Chokri\PDF\Pdf;

$pdf = new Pdf();
$pdf->addTitlePage('My PDF Title', 'Subtitle', 'Author Name');
$pdf->addTable(['Col1', 'Col2'], [['A', 'B'], ['C', 'D']]);
$pdf->addImageCentered('logo.png', 80);
$pdf->addPageNumbering();
$pdf->Output('I', 'example.pdf');
```

## Features

- Easy to use
- PSR-4 autoloading
- PHP 8.4+ support
- GPL-3.0 license
- Write HTML with `WriteHTML()`
- Add tables and images
- Custom header and footer
- Unit tested with PHPUnit

## License

GPL-3.0-or-later. See [LICENCE](LICENCE).

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for updates.

## Author

Chokri Khalifa — [chokrikhalifa.com](http://chokrikhalifa.com)
