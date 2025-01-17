<?php

namespace MLSC\Modules\Display;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\FormatterHelper;

class ConsoleOutput
{
    public $formatter;
    public $output;
    public $BarSection1;

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
        $this->output->getFormatter()->setStyle('effect', new OutputFormatterStyle('bright-magenta'));
        $this->output->getFormatter()->setStyle('download', new OutputFormatterStyle('bright-blue'));
        $this->output->getFormatter()->setStyle('file', new OutputFormatterStyle('bright-cyan'));

        $this->BarSection1      = $this->output->section();
        $this->BarSection2      = $this->output->section();
        $this->fileCountSection = $this->output->section();
        $this->fileInfoSection  = $this->output->section();
        $this->MetaBlockSection = $this->output->section();
        $this->processOutput    = $this->output->section();
        $this->VideoInfoSection = $this->output->section();
        $this->BarBottom        = $this->output->section();
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
