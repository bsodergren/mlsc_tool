<?php

namespace MLSC\Modules\Exec;

use MLSC\Traits\Callables;
use Symfony\Component\Process\Process;

class Executable
{
    use Callables;

    public $process;
    public $errors;

    public $input;
    public $output;
    public $runCommand;
    protected $optionArgs = [];

    public function __construct($input = null, $output = null)
    {
        $this->input  = $input;
        $this->output = $output;
    }

    public function getOptionArgs()
    {
        return $this->optionArgs;
    }

    public function addOptionArg($option)
    {
        $this->optionArgs[] = $option;
    }

    public function setCommand($command)
    {
        $cmd[] = $command;
        foreach ($this->optionArgs as $option) {
            $cmd[] = $option;
        }

        $this->process = new Process($cmd);
        $this->process->setTimeout(60000);

        return $this;
    }

    public function getCommand()
    {
        return $this->process->getCommandLine();
    }

    public function exec($callback = null): mixed
    {
        $this->process->start();
        $this->process->wait($callback);

        return $this->errors;
    }
}
