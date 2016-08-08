<?php

namespace AppBundle\Controller;

use Component\Breaker\Breaker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $string = file_get_contents('http://www.symfony.com');

        $breaker = new Breaker();

        $pattern = $breaker->guessSeparator($string);

        dump('sep: '.$pattern);

        $pattern = $breaker->guessPattern($string);

        dump('pattern: '.$pattern);

        preg_match_all($pattern, $string, $pattern);

        dump($pattern);exit();


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
