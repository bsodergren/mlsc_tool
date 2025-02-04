<?php

namespace MLSC\Utilities;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use UTM\Utilities\Option;

class MLSCStopWatch
{
    public static $clock    = false;
    public static $display  = false;
    public static $writeNow = false;
    private static $stopwatch;
    private static $io;
    private static $timerLog   = __LOGFILE_DIR__.'/timer.log';
    private static $watchArray = [];

    private static $stopWatchName = 'default';

    public static function formatPrint(string $text = '', array $format = [])
    {
        if (true == self::$display) {
            //      return $text;
        }

        $codes = [
            'bold'    => 1,
            'italic'  => 3, 'underline' => 4, 'strikethrough' => 9,
            'black'   => 30, 'red' => 31, 'green' => 32, 'yellow' => 33, 'blue' => 34, 'magenta' => 35, 'cyan' => 36, 'white' => 37,
            'blackbg' => 40, 'redbg' => 41, 'greenbg' => 42, 'yellowbg' => 44, 'bluebg' => 44, 'magentabg' => 45, 'cyanbg' => 46, 'lightgreybg' => 47,
        ];
        $formatMap = array_map(function ($v) use ($codes) { return $codes[$v]; }, $format);

        return "\e[".implode(';', $formatMap).'m'.$text."\e[0m";
    }

    public static function varexport($expression, $return = false)
    {
        $export   = var_export($expression, true);
        $patterns = [
            '/array \\(/'                           => '[',
            '/^([ ]*)\\)(,?)$/m'                    => '$1]$2',
            "/=>[ ]?\n[ ]+\\[/"                     => '=> [',
            "/([ ]*)(\\'[^\\']+\\') => ([\\[\\'])/" => '$1$2 => $3',
        ];
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        if ((bool) $return) {
            return $export;
        }
        // echo $export;
    }

    public static function init(InputInterface $input, OutputInterface $output)
    {
        global $_SERVER;

        Option::init($input);

        if (Option::isTrue('time')) {
            $file   = self::$timerLog;
            $string = self::formatPrint(implode(' ', $_SERVER['argv']), ['green', 'italic']).\PHP_EOL;
            file_put_contents($file, $string);
            self::$io        = new SymfonyStyle($input, $output);
            self::$stopwatch = new Stopwatch();
            self::$stopwatch->start(self::$stopWatchName);
        }
    }

    public static function dump($text, $var)
    {
        if (Option::isTrue('time')) {
            self::$clock = (string) self::$stopwatch->getEvent(self::$stopWatchName);
            // $text = sprintf("%-20s",   $text);
            // $var = str_replace("\n"," ", var_export($var,1));

            $var = preg_replace('/(\s{1,})/m', ' ', var_export($var, 1));

            //                $var = self::varexport($var,true);

            self::log([0 => [$text.' ', self::$clock.' ', $var]]);
        }
    }

    public static function stop($text, $var)
    {
        if (Option::isTrue('time')) {
            self::$stopwatch->stop(self::$stopWatchName);
            self::dump($text, $var);
            if (false === self::$writeNow) {
                self::$writeNow = true;
                self::log(self::$watchArray);
                self::$writeNow = false;
            }
        }
    }

    public static function lap($text, $var)
    {
        if (Option::isTrue('time')) {
            self::$stopwatch->lap(self::$stopWatchName);
            self::dump($text, $var);
        }
    }

    public static function log($array)
    {
        if (true == self::$display) {
            $string[] = implode('', $array[0]);

            self::$io->listing($string);
        } else {
            if (true === self::$writeNow) {
                self::writeLog($array);
            } else {
                self::$watchArray[] = $array[0];
            }
        }
    }

    private static function writeLog($array)
    {
        $file       = self::$timerLog;
        $maxtxtLen  = 0;
        $maxTimeLen = 0;

        foreach ($array as $n => $row) {
            $len = \strlen($row[0]);
            if ($len > $maxtxtLen) {
                $maxtxtLen = $len;
            }
            $len = \strlen($row[1]);
            if ($len > $maxTimeLen) {
                $maxTimeLen = $len;
            }
        }

        foreach ($array as $n => $row) {
            $txt  = str_pad($row[0], $maxtxtLen);
            $time = str_pad($row[1], $maxTimeLen);
            //            $cmd        = str_pad($row[2], $maxCmdLen);
            $var = $row[2];

            $strArray[] = $txt.', '.$time.', '.$var;
        }

        $string = implode(\PHP_EOL, $strArray).\PHP_EOL;
        // $string = var_export($array,1);
        file_put_contents($file, $string, \FILE_APPEND);
    }
}
