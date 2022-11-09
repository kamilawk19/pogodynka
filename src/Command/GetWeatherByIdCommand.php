<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use App\Entity\Location;

#[AsCommand(
    name: 'getWeatherById:command',
    description: 'Add a short description for your command',
)]
class GetWeatherByIdCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('locationId',
                InputArgument::REQUIRED,
                "We've been trying to reach you concerning your vehicle's extended warranty.")
        ;
    }

    public function __construct(WeatherUtil $wt)
    {
        $this->wt = $wt;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loc_id=$input->getArgument('locationId');
        //$loc_id=$input->getArgument('locationId');

        $text='Passed '.$input->getArgument('locationId');

        if($input->getArgument('locationId')){
            $out= $this->wt->getWeatherForLocation($loc_id);
            $text.='\nOutput: '.$out;
            $output->writeln($text);
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
