<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Core;

use MLSC\Utilities\Option;
use MLSC\Modules\Display\ConsoleOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class MLSC extends Command
{
    public static $output;

    public $command;
    public $defaultCommands;

    public static $input;

    public static $console;
    public $commandList;
    public $helper;
    public $default = [
        'exec'  => null,
        'print' => null,
    ];

    public function __construct(InputInterface $input = null, OutputInterface $output = null, $args = null)
    {
        self::boot($input, $output);
    }

    public function boot(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->command = self::getDefaultName();
        self::$input   = $input;
        self::$output  = $output;
        self::$console = new ConsoleOutput($output);

        MLSCCache::init($input, $output);
        Option::init($input);
    }

    public function process()
    {
        $ClassCmds = $this->runCommand();
        foreach ($ClassCmds as $cmd => $option)
        {
            if (method_exists($this, $cmd))
            {
                $this->{$cmd}($option);
            } else
            {
                self::$output->writeln('<info>'.$cmd.' doesnt exist</info>');

                return 0;
            }
        }
    }

    public function exec($option = null)
    {
    }

    public function print()
    {
    }

    public function runCommand()
    {
        $array   = $this->commandList;

        $default = $this->default;
        if (isset($this->defaultCommands))
        {
            $default = $this->defaultCommands;
        }

        foreach (Option::getOptions() as $option => $value)
        {
            if (key_exists($option, $array))
            {
                $cmd = $option;
                foreach ($array[$option] as $method => $args)
                {
                    if (null !== $args)
                    {
                        $commandArgs = option::getValue($cmd);

                        if (is_array($commandArgs))
                        {
                            if (key_exists(0, $commandArgs))
                            {
                                if ('isset' == $args)
                                {
                                    $Commands[$method] = $commandArgs[0];

                                    continue;
                                }
                            }
                        }
                        $args        = $commandArgs;
                    }
                    $Commands[$method] = $args; // => $value];
                    if ('default' == $method)
                    {
                        unset($Commands[$method]);
                        $Commands = array_merge($Commands, $default);
                    }
                }
            }
        }

        if (!isset($Commands))
        {
            $Commands = $default;
        }

        return $Commands;
    }

    public static function get_caller_info()
    {
        $lineno = '';
        $trace  = debug_backtrace();
        $s      = [];
        $file   = $trace[1]['file'];

        foreach ($trace as $i => $row)
        {
            $class = '';

            switch ($row['function'])
            {
                case __FUNCTION__:
                    break;

                case 'dump':
                    $lineno = $row['line'];

                    // break;
                    // no break
                case 'dd':
                    $lineno = $row['line'];

                    break;

                case 'trace':
                case 'require_once':
                case 'include_once':
                case 'require':
                case 'include':
                case '__construct':
                case '__directory':
                case '__filename':
                case '__dump':
                    break;

                default:
                    if ('' != $row['class'])
                    {
                        $class = $row['class'].$row['type'];
                    }
                    $s[]    = $class.$row['function'].'()';

                    // $file   = $row['file'];
                    break;
            }
            // if($i == 5){
            //     break;
            // }
            ++$i;
        }
        //  $s = array_reverse($s);
        $s_str  = implode("->", $s);
        $file   = pathinfo($file, \PATHINFO_BASENAME);

        return $file.':'.$lineno.':'.$s_str;
    }
}
