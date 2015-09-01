<?php

namespace Wrseward\PdfParser\Process;

use Symfony\Component\Process\Process as BaseProcess;
use Wrseward\PdfParser\Interfaces\ProcessInterface;

class Process implements ProcessInterface
{
    /**
     * The wrapped Symfony Process component
     *
     * @var \Symfony\Component\Process\Process
     */
    protected $process;

    /**
     * The command
     *
     * @var string
     */
    protected $command;

    /**
     * Construct an instance.
     *
     * @param \Symfony\Component\Process\Process $process
     */
    public function __construct(BaseProcess $process = null)
    {
        $this->process = is_null($process) ? new BaseProcess('') : $process;
    }

    /**
     * Run a command as a process.
     *
     * @param string $command
     * @return self
     */
    public function run($command)
    {
        $this->command = escapeshellcmd($command);
        $this->process->setCommandLine($this->command);
        $this->process->run();
        $this->validateRun();

        return $this;
    }

    /**
     * Validate that a run process was successful.
     *
     * @throws \RuntimeException
     * @return void
     */
    protected function validateRun()
    {
        $status = $this->process->getExitCode();
        $error  = $this->process->getErrorOutput();

        if ($status !== 0 and $error !== '') {
            throw new \RuntimeException(sprintf(
                'The exit status code \'%s\' says something went wrong:' . "\n"
                . 'stderr: "%s"' . "\n"
                . 'stdout: "%s"' . "\n"
                . 'command: %s.',
                $status, $error, $this->process->getOutput(), $this->command
            ));
        }
    }

    /**
     * Get the output of the command.
     *
     * @return string
     */
    public function output()
    {
        return $this->process->getOutput();
    }
}
