<?php

namespace AppBundle\Command;

use Component\Pulse\Pattern\Adapter\Adapter;
use Component\Pulse\Pattern\Factory;
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
        $output->writeln($this->format('Pulse','Start'));

        $refText = file_get_contents('data/ref.txt');

        $text = new Text($refText);

        $factory = Factory::getInstance();

        $node = null;
        $adapter = null;

        foreach($text->getParts() as $part) {
            try{
                if($adapter) {
                    $output->writeln($this->format('Pulse', 'Next: '.$part. '('.$text->getOccurrencesRate($part).'%)'));
                    $output->writeln($this->format('Pulse', 'Result: '.$node->process()));
                    //dump($node);exit();
                    break;
                }

                if($text->getOccurrencesRate($part) >= 4.7) {
                    $adapted = $factory->create($part);
                    $adapter = new Adapter();
                    $adapter->setAdapted($adapted);

                    $node->setAdapter($adapter);
                    $output->writeln($this->format('Adapter', sprintf('"%s" created', $part)));
                } else {
                    $node = $factory->create($part);
                    $output->writeln($this->format('Factory', sprintf('"%s" created', $part)));
                }
            } catch (ProcessException $e) {
                $output->writeln($this->format('Pulse', sprintf('"%s" can\'t be processed', $part)));
                break;
            } catch (\Exception $e) {
                $output->writeln($this->format('Pulse', $e->getMessage()));
                break;
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
