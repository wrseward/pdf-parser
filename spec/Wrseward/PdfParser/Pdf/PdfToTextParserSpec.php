<?php

namespace spec\Wrseward\PdfParser\Pdf;

use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Wrseward\PdfParser\Interfaces\ProcessInterface;

class PdfToTextParserSpec extends ObjectBehavior
{
    public function let(ProcessInterface $process)
    {
        $this->beConstructedWith('/usr/bin/pdftotext', $process);
        vfsStream::newFile('file.pdf')->at(vfsStream::setup('pdfs'))->setContent('Whatever');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Wrseward\PdfParser\Pdf\PdfToTextParser');
    }

    public function it_builds_the_command_and_runs_a_process(ProcessInterface $process)
    {
        $file = vfsStream::url('pdfs/file.pdf');
        $this->beConstructedWith('/usr/bin/pdftotext', $process);

        $this->parse($file);

        $process->run("/usr/bin/pdftotext {$file} -")->shouldHaveBeenCalled();
    }

    public function it_returns_the_output_of_the_command(ProcessInterface $process)
    {
        $file = vfsStream::url('pdfs/file.pdf');
        $this->beConstructedWith('/usr/bin/pdftotext', $process);
        $process->run(Argument::any())->willReturn();
        $process->output()->willReturn('Parsed Text');

        $this->parse($file);

        $this->text()->shouldReturn('Parsed Text');
    }

    public function it_allows_method_chaining(ProcessInterface $process)
    {
        $file = vfsStream::url('pdfs/file.pdf');
        $process->run(Argument::any())->willReturn();
        $process->output()->willReturn('Parsed Text');

        $this->parse($file)->text()->shouldReturn('Parsed Text');
    }

    public function it_outputs_is_null_when_no_file_has_been_parsed(ProcessInterface $process)
    {
        $this->text();

        $this->text()->shouldBeNull();
        $process->run(Argument::any())->shouldNotHaveBeenCalled();
        $process->output()->shouldHaveBeenCalled();
    }

    public function it_throws_an_exception_when_the_file_does_not_exists(ProcessInterface $process)
    {
        $this->beConstructedWith('/usr/bin/pdftotext', $process);

        $this->shouldThrow('Wrseward\PdfParser\Exceptions\PdfNotFoundException')->duringParse('filethatdoesnotexist.pdf');
        $process->run(Argument::any())->shouldNotHaveBeenCalled();
    }


    public function it_throws_an_exception_when_binary_is_empty(ProcessInterface $process)
    {
        $this->beConstructedWith('', $process);

        $this->shouldThrow('Wrseward\PdfParser\Exceptions\PdfBinaryNotDefinedException')->duringParse('file.pdf');
        $process->run(Argument::any())->shouldNotHaveBeenCalled();
    }

    public function it_throws_an_exception_when_binary_is_null(ProcessInterface $process)
    {
        $this->beConstructedWith(null, $process);

        $this->shouldThrow('Wrseward\PdfParser\Exceptions\PdfBinaryNotDefinedException')->duringParse('file.pdf');
        $process->run(Argument::any())->shouldNotHaveBeenCalled();
    }
}
