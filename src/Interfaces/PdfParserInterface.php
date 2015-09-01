<?php

namespace Wrseward\PdfParser\Interfaces;

interface PdfParserInterface
{
    /**
     * Parse a PDF file.
     *
     * @param string $file
     * @return self
     */
    public function parse($file);

    /**
     * Get the text from a parsed PDF file.
     *
     * @return string
     */
    public function text();
}
