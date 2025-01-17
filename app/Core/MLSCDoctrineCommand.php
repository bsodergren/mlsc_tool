<?php

namespace MLSC\Core;

use Doctrine\Migrations\Tools\Console\Command\DoctrineCommand;

class MLSCDoctrineCommand extends DoctrineCommand
{
    public function configure(): void
    {
        $this->setName(static::$defaultName)->setDescription(static::$defaultDescription);

        $definition = CmdOptions::get($this->getName());

        $this->setDefinition($definition);
    }
}
