<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Component\Text\Text;

class PulseTextCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pulse:text')
            ->setDescription('...')
//            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('dump', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->format('Pulse','Text'));

        $refText = file_get_contents('data/ref.txt');

        $text = new Text($refText);

        foreach($text->getParts() as $part) {
            if($input->getOption('dump')){
                file_put_contents('dump.csv', $part.";".$text->getOccurrencesRate($part)."\n", FILE_APPEND);
            } else {
                $output->writeln($this->format('Pulse', $part . '(' . $text->getOccurrencesRate($part) . '%)'));
            }
        }
    }

    protected function format($section, $text)
    {
        $formatter = $this->getHelper('formatter');

        $formattedLine = $formatter->formatSection(
            $section,
            $text
        );

        return $formattedLine;
    }
}
