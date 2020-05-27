<?php

namespace Inviqa\BehatDemo\Console\Command;

use Inviqa\BehatDemo\Generator\EmailGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateEmailAddressCommand extends Command
{
    /** @var EmailGenerator */
    private $emailGenerator;

    public function __construct(EmailGenerator $emailGenerator)
    {
        $this->emailGenerator = $emailGenerator;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('generate:email:address')
            ->setDescription('Generate an email address for a given name')
            ->addArgument('name', InputArgument::REQUIRED, 'Employee\'s first name');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $result = $this->emailGenerator->generate($name);

        $output->writeln($result);

        return 0;
    }
}
