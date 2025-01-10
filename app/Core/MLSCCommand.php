<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Core;

use MLSC\Utilities\Timer;
use MLSC\Bundle\Monolog\MLSCLog;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\ExceptionInterface;

class MLSCCommand extends MLSCDoctrineCommand
{
    public static $optionArg             = [];

    //    private ?Application $application = null;
    //    private ?string $name = null;
    private ?string $processTitle        = null;
    //    private array $aliases = [];
    //    private InputDefinition $definition;
    //    private bool $hidden = false;
    //    private string $help = '';
    //    private string $description = '';
    //   private ?InputDefinition $fullDefinition = null;
    private bool $ignoreValidationErrors = false;
    private ?\Closure $code              = null;
    //   private array $synopsis = [];
    //  private array $usages = [];
    //  private ?HelperSet $helperSet = null;


    public $CommandArguments             = null;

    public function getSubscribedSignals(): array
    {
        // return here any of the constants defined by PCNTL extension
        return [\SIGINT, \SIGTERM];
    }

    public function handleSignal(int $signal): void
    {
        if (\SIGINT === $signal)
        {
            echo \PHP_EOL;
            echo 'Exiting, cleaning up';
            echo \PHP_EOL;

            exit;
        }

        // ...
    }

    public function configure(): void
    {
        $child      = get_called_class();
        $this->setName($child::CMD_NAME)->setDescription($child::CMD_DESCRIPTION);

        $this->setDefinition(MLSCOptions::getDefinition($this->getName()));

        $arguments  = MLSCOptions::getArguments($child::CMD_NAME, $child::CMD_DESCRIPTION);
        if (is_array($arguments))
        {
            $this->addArgument(...$arguments);
        }

        if ($this->CommandArguments !== null)
        {
            foreach ($this->CommandArguments as $cmd)
            {
                $this->addArgument($cmd[0], InputArgument::{$cmd[1]}, $cmd[2]);
            }
        }
    }

    /**
     * Runs the command.
     *
     * The code to execute is either defined directly with the
     * setCode() method or by overriding the execute() method
     * in a sub-class.
     *
     * @return int The command exit code
     *
     * @throws ExceptionInterface When input binding fails. Bypass this by calling {@link ignoreValidationErrors()}.
     *
     * @see setCode()
     * @see execute()
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        // add the application arguments and options
        $this->mergeApplicationDefinition();

        // bind the input against the command specific arguments/options
        try
        {
            $input->bind($this->getDefinition());
        } catch (ExceptionInterface $e)
        {
            if (!$this->ignoreValidationErrors)
            {
                throw $e;
            }
        }
        // MLSCLog::logger('start');
        Timer::startWatch($input, $output, ['log' => __TIMER_LOG__, 'display' => __TIMER_DISPLAY__]);

        $this->initialize($input, $output);
        // MLSCLog::logger('After initialize');

        if (null !== $this->processTitle)
        {
            if (\function_exists('cli_set_process_title'))
            {
                if (!@cli_set_process_title($this->processTitle))
                {
                    if ('Darwin' === \PHP_OS)
                    {
                        $output->writeln('<comment>Running "cli_set_process_title" as an unprivileged user is not supported on MacOS.</comment>', OutputInterface::VERBOSITY_VERY_VERBOSE);
                    } else
                    {
                        cli_set_process_title($this->processTitle);
                    }
                }
            } elseif (\function_exists('setproctitle'))
            {
                setproctitle($this->processTitle);
            } elseif (OutputInterface::VERBOSITY_VERY_VERBOSE === $output->getVerbosity())
            {
                $output->writeln('<comment>Install the proctitle PECL to be able to change the process title.</comment>');
            }
        }

        if ($input->isInteractive())
        {
            $this->interact($input, $output);
        }

        // The command name argument is often omitted when a command is executed directly with its run() method.
        // It would fail the validation if we didn't make sure the command argument is present,
        // since it's required by the application.
        if ($input->hasArgument('command') && null === $input->getArgument('command'))
        {
            $input->setArgument('command', $this->getName());
        }

        $input->validate();

        if ($this->code)
        {
            $statusCode = ($this->code)($input, $output);
        } else
        {
            $statusCode = $this->execute($input, $output);
            //  stopwatch();

            if (!\is_int($statusCode))
            {
                throw new \TypeError(sprintf('Return value of "%s::execute()" must be of the type int, "%s" returned.', static::class, get_debug_type($statusCode)));
            }
        }

        return is_numeric($statusCode) ? (int) $statusCode : 0;
    }

    public static function getProcessClass()
    {
        $className   = get_called_class();
        $classPath   = rtrim($className, "Command");
        $classPath .= "Process";
        // MLSCLog::logger('Claas Path', $classPath);

        //  $classPath   = str_replace('\Command', '\\Process', $className);
        return $classPath;
    }



    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //      $args    = [$input, $output];
        // if (null !== self::$optionArg)
        // {
        //     $args = array_merge($args, self::$optionArg);
        // }

        $arguments = $input->getArguments();

        if (\count($arguments) > 0)
        {
            foreach ($arguments as $cmd => $value)
            {
                if ($value == $cmd)
                {
                    continue;
                }
                $cmdArgument[] = $input->getArgument($cmd);
            }


            // $cmdArgument = $input->getArgument("command");


            if (null !== $cmdArgument)
            {
                self::$optionArg = array_merge(self::$optionArg, $cmdArgument);
            }


            //
        }



        $class     = self::getProcessClass();
        $Process   = new $class(...array_merge([$input, $output], self::$optionArg));
        // dd($class,self::$optionArg);

        // $Process = new $class(...$args);
        // if (isset(parent::$AskQuestion))
        // {
        //     $Process->helper = $this->getHelper(parent::$AskQuestion);
        // }

        $Process->process();


        return Command::SUCCESS;
    }


    // protected function execute(InputInterface $input, OutputInterface $output)
    // {
    //     $args    = [$input, $output];
    //     if (null !== self::$optionArg)
    //     {
    //         $args = array_merge($args, self::$optionArg);
    //     }

    //     $class   = self::getProcessClass();
    //     $Process = new $class(...$args);
    //     if (isset(parent::$AskQuestion))
    //     {
    //         $Process->helper = $this->getHelper(parent::$AskQuestion);
    //     }

    //     $Process->process();

    //     return Command::SUCCESS;
    // }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $className = get_called_class();
        // MLSCLog::logger('Class Name', $className);
    }
}
