<?php

namespace AppBundle\Command;

use Component\Organic\Text;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrganicTextCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('organic:text')
            ->setDescription('...')
//            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('concentration', 'c', InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = file_get_contents('data/ref1.txt');

        $text = new Text($content);

        $text->setContent(null);

        if($input->getOption('concentration')) {
            $dump = '';

            foreach($text->getPartsConcentration() as $part => $concentration) {
                $dump .= $part.";".number_format($concentration, 2, ',', ' ')."\n";
            }

            file_put_contents('dump.csv', $dump);
            exit();
        }

        $message = '(Init) ';

        $moy = 1.23;
        $max = 1.84;

        $concentrations = $text->getPartsConcentration();

        foreach($text->getParts() as $part) {
            $concentration = $concentrations[$part];
            if($concentration >= $moy && $concentration < $max) {
                $output->writeln($message);
                $message = '';
            }

            if($concentration >= $max) {
                $message .= '['.$part.']'.$text->getSeparator();
            } else {
                if($message == '') {
                    $message .= '('.$part.')'.$text->getSeparator();
                } else {
                    $message .= $part.$text->getSeparator();
                }
            }
        }

        $output->writeln($message);
    }

}
