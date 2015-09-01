# wrseward/pdf-parser

PHP library to parse PDF files to text. A wrapper for pdftotext.

[![Build Status](https://travis-ci.org/wrseward/pdf-parser.svg?branch=master)](https://travis-ci.org/wrseward/pdf-parser)

## Installation

Via Composer

```bash
composer require wrseward/pdf-parser
```

### `pdftotext` binary

Debian / Ubuntu

```bash
apt-get install poppler-utils
```

RedHat / CentOS

```bash
yum install poppler-utils
```

OS X

```bash
brew install xpdf
```

Verify your installation / Get the path of the binary

```bash
which pdftotext
```

## Usage

```php
$parser = new \Wrseward\PdfParser\Pdf\PdfToTextParser('/usr/bin/pdftotext');
$parser->parse('/path/to/file.pdf');
echo $parser->text();
```

## Running tests

```bash
./vendor/bin/phpspec run
```

## License

[MIT](https://github.com/wrseward/pdf-parser/blob/master/LICENSE)
