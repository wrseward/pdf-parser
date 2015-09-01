<?php

namespace spec\Wrseward\PdfParser\Process;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new \Symfony\Component\Process\Process(''));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Wrseward\PdfParser\Process\Process');
    }

    public function it_returns_process_output()
    {
        $this->run('echo foo');

        $this->output()->shouldBe("foo\n");
    }

    public function it_returns_empty_process_output()
    {
        $this->run('echo');

        $this->output()->shouldReturn("\n");
    }

    public function it_escapes_shell_commands()
    {
        $this->run('echo $PATH');

        $this->output("\$PATH\n");
    }

    public function it_allows_method_chaining()
    {
        $this->run('echo foo')->output()->shouldReturn("foo\n");
    }

    public function it_throws_an_exception_when_there_is_an_error()
    {
        $this->shouldThrow('\RuntimeException')->duringRun('commanddoesnotexist');
    }

    public function it_throws_an_exception_when_no_process_has_been_run()
    {
        $this->shouldThrow('\Symfony\Component\Process\Exception\LogicException')->duringOutput();
    }
}
