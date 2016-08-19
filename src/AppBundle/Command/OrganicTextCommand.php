<?php

namespace AppBundle\Command;

use Component\Organic\NodeFactory;
use Component\Organic\Text;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
        $content = file_get_contents('data/ref.txt');

        $text = new Text($content);

        $concentrations = $text->getPartsConcentration();

        if($input->getOption('concentration')) {
            $dump = '';

            foreach($text->getParts() as $part) {
                $concentration = $concentrations[$part];
                $dump .= $part.";".number_format($concentration, 2, ',', ' ')."\n";
            }
            
            file_put_contents('dump.csv', $dump);
            exit();
        }

        $partOccurences = $text->getPartOccurrences();
        $message = '';
        $nbParts = 0;
        $format = 'subject: ';
        $preset = '';

        foreach($text->getParts() as $key => $part) {
            $count = $partOccurences[$part];

            if ($count >= $text->getThreshold() && $count < $text->getCeil()) {
                if($nbParts == 0) {
                    $preset .= '{{'.$part.'}}'.$text->getSeparator();
                } else {
                    $message .= '('.$part.')'.$text->getSeparator();
                    $format .= '[Pr]';
                }

                $nbParts++;
            } elseif ($count >= $text->getCeil()) {
                $message .= '['.$part.']'.$text->getSeparator();
                $format .= '[Lp]';
            } else {
                $message .= $part.$text->getSeparator();
                $format .= '[Un]';
            }

            if ($nbParts > 1){
                $output->writeln($preset.$message);
                $output->writeln($format);
                $message = '';
                $preset = '';
                $format = 'Subject: ';
                $nbParts = 0;

                if($key >= 5){
                    break;
                }
            }
        }
    }
}
