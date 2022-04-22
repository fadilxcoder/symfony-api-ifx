<?php

namespace App\Command;

use App\Services\SecurityToken;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateXClientCommand extends Command
{
    protected static $defaultName = 'generate-x-client';
    protected static $defaultDescription = 'Generate encrypted X-Client header';
    private $securityToken;

    public function __construct(SecurityToken $securityToken)
    {
        $this->securityToken = $securityToken;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>X-Client token : '.$this->securityToken->getToken().'</info>');

        return Command::SUCCESS;
    }
}
