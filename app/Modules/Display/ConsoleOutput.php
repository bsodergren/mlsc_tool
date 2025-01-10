<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Modules\Display;

use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ConsoleOutput
{
    public $formatter;
    public $output;

    public function __construct($output)
    {
        /*
        black, red, green, yellow, blue,
        magenta, cyan, white, gray,
        bright-red, bright-green, bright-yellow,
        bright-blue, bright-magenta, bright-cyan
        bright-white

        bold, underscore, blink, reverse
        */

        $this->output    = $output;
        $this->formatter = new FormatterHelper();
        $this->output->getFormatter()->setStyle('id', new OutputFormatterStyle('yellow'));
        $this->output->getFormatter()->setStyle('text', new OutputFormatterStyle('green'));
        $this->output->getFormatter()->setStyle('error', new OutputFormatterStyle('red'));
        $this->output->getFormatter()->setStyle('playlist', new OutputFormatterStyle('bright-magenta'));
        $this->output->getFormatter()->setStyle('download', new OutputFormatterStyle('bright-blue'));
        $this->output->getFormatter()->setStyle('file', new OutputFormatterStyle('bright-cyan'));
    }

    public function write($text)
    {
        $this->output->write($text);
    }

    public function writeln($text)
    {
        $this->output->writeln($text);
    }
}
