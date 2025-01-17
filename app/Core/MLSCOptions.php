<?php

namespace MLSC\Core;

use MLSC\Locales\Lang;
use MLSC\Traits\Translate;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * CmdOptions.
 */
class MLSCOptions
{
    use Lang;
    use Translate;

    public $options;
    public static $classObj;

    public function Arguments($varName = null, $description = null)
    {
        return null;
    }

    public function Definitions()
    {
        return null;
    }

    public static function getClassObject($command)
    {
        $command   = ucfirst(strtolower($command));
        $className = $command.'\\Options';
        $className = 'MLSC\\Commands\\'.$className;

        if (class_exists($className)) {
            self::$classObj = new $className();
        }
    }

    /**
     * Method get.
     *
     * @param mixed|null $command
     */
    public static function getDefinition($command = null)
    {
        $commandOptions = []; // self::getDefaultOptions();
        $testOptions    = self::getTestOptions();

        self::getClassObject($command);

        if (\is_object(self::$classObj)) {
            if (isset(self::$classObj->options)) {
                foreach (self::$classObj->options as $option => $value) {
                    if (\is_int($option)) {
                        $option = $value;
                    }

                    // if($value === false){
                    // switch ($option)
                    // {
                    //     case 'Default':$commandOptions         = [];
                    //         break;
                    //     case 'DefaultOptions': $commandOptions = [];
                    //         break;
                    //     case 'Test':$testOptions               = [];
                    //         break;
                    //     case 'TestOptions': $testOptions       = [];
                    //         break;
                    // }
                    // } else {
                    $method = 'get'.$option.'Options';
                    //    dd($method,method_exists(self::$classObj, $method));

                    if (method_exists(self::$classObj, $method)) {
                        $commandOptions = array_merge($commandOptions, self::$classObj->$method());
                    }
                    // }
                }
            }

            $definitions = self::$classObj->Definitions();

            if (\is_array($definitions)) {
                $commandOptions = array_merge(self::getOptions($definitions), $commandOptions);
            }
        }
        // $commandOptions =  array_merge($commandOptions, $testOptions);

        return new InputDefinition($commandOptions);
    }

    public static function getArguments($varName = null, $description = null)
    {
        //    self::getClassObject();
        if (\is_object(self::$classObj)) {
            return self::$classObj->Arguments($varName, $description);
        }

        return null;
    }

    public static function getOptions($optionArray)
    {
        if (!\is_array($optionArray)) {
            return [];
        }

        $cnt            = \count($optionArray);
        $commandOptions = [];
        $i              = 0;
        $prev           = '';

        foreach ($optionArray as $idx => $optionName) {
            ++$i;
            if ('break' == $optionName[0]) {
                $key = $idx - 1;
                $prev[3] .= \PHP_EOL;
                $commandOptions[$key] = new InputOption(...$prev);

                continue;
            }

            if ($i == $cnt) {
                $optionName[3] .= \PHP_EOL;
            }
            $prev             = $optionName;
            $commandOptions[] = new InputOption(...$optionName);
        }

        return $commandOptions;
    }

    public static function getDefaultOptions()
    {
        Translate::$Class = __CLASS__;

        $options = [
            ['filelist', 'f', InputOption::VALUE_REQUIRED, Translate::text('L__DEFAULT_FILELIST')],
            ['max', 'M', InputOption::VALUE_REQUIRED, Translate::text('L__DEFAULT_MAX')],
            ['range', 'r', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, Translate::text('L__DEFAULT_RANGE')],
            ['filenumber', 'F', InputOption::VALUE_REQUIRED, Translate::text('L__DEFAULT_FILENUMBER')],
        ];

        return self::getOptions($options);
    }

    public static function getTestOptions()
    {
        Translate::$Class = __CLASS__;

        $options = [
            ['test', null, InputOption::VALUE_NONE, Translate::text('L__TEST_CMD')],
            ['preview', 'p', InputOption::VALUE_NONE, Translate::text('L__TEST_PREVIEW')],
            ['time', null, InputOption::VALUE_NONE, Translate::text('L__TEST_TIME')],
            ['dump', null, InputOption::VALUE_OPTIONAL, Translate::text('L__TEST_DUMP')],
            ['flush', null, InputOption::VALUE_NONE, Translate::text('L__TEST_FLUSH')],
        ];

        return self::getOptions($options);
    }
}
