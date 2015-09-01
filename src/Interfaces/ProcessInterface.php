<?php

namespace Wrseward\PdfParser\Interfaces;

interface ProcessInterface
{
    /**
     * Run a command as a process.
     *
     * @param string $command
     * @return self
     */
    public function run($command);

    /**
     * Get the output of the command.
     *
     * @return string
     */
    public function output();
}
