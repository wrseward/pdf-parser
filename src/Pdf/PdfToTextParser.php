<?php

namespace Wrseward\PdfParser\Pdf;

use Wrseward\PdfParser\Exceptions\PdfBinaryNotDefinedException;
use Wrseward\PdfParser\Exceptions\PdfNotFoundException;
use Wrseward\PdfParser\Interfaces\PdfParserInterface;
use Wrseward\PdfParser\Interfaces\ProcessInterface;
use Wrseward\PdfParser\Process\Process;

class PdfToTextParser implements PdfParserInterface
{
    /**
     * The full path to the pdftotext binary.
     *
     * @var string
     */
    protected $binary;

    /**
     * The process to run the binary.
     *
     * @var \Wrseward\PdfParser\Interfaces\ProcessInterface
     */
    protected $process;

    /**
     * The full path to the PDF file.
     *
     * @var string
     */
    protected $file;

    /**
     * Construct an instance.
     *
     * @param string $binary
     * @param ProcessInterface $process
     */
    public function __construct($binary, ProcessInterface $process = null)
    {
        $this->binary  = $binary;
        $this->process = is_null($process) ? new Process() : $process;
    }

    /**
     * Parse a PDF file.
     *
     * @param string $file
     * @throws PdfBinaryNotDefinedException
     * @throws PdfNotFoundException
     * @return self
     */
    public function parse($file)
    {
        $this->file = $file;
        $this->validateSelf();
        $this->process->run("{$this->binary} {$this->file} -");

        return $this;
    }

    /**
     * Validate everything needed for parsing.
     *
     * @throws PdfBinaryNotDefinedException
     * @throws PdfNotFoundException
     * @return void
     */
    protected function validateSelf()
    {
        if ($this->binary === null || $this->binary === '') {
            throw new PdfBinaryNotDefinedException('You must set a location for the pdftotext binary');
        }

        if (! file_exists($this->file)) {
            throw new PdfNotFoundException("PDF file not found: {$this->file}");
        }
    }

    /**
     * Get the text from a parsed PDF file.
     *
     * @return string
     */
    public function text()
    {
        return $this->process->output();
    }
}
