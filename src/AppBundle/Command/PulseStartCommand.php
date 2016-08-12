<?php

namespace AppBundle\Command;

use Component\Text\Text;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Component\Process\ProcessException;

class PulseStartCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pulse:start')
            ->setDescription('...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');

        $formattedLine = $formatter->formatSection(
            'Pulse',
            'Start'
        );
        $output->writeln($formattedLine);

        $refText = file_get_contents('data/ref.txt');

        $text = new Text($refText);

        foreach($text->getParts() as $part) {
            try{
                throw new \Exception('test');

            } catch (ProcessException $e) {
                $formattedLine = $formatter->formatSection(
                    'Pulse',
                    sprintf('"%s" can\'t be processed', $part)
                );

                $output->writeln($formattedLine);
                break;
            } catch (\Exception $e) {
                $formattedLine = $formatter->formatSection(
                    'Pulse',
                    $e->getMessage()
                );

                $output->writeln($formattedLine);
                break;
            }
        }
    }

}
