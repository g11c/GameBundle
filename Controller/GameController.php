<?php

namespace g11c\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GameController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
       /* $code = Radomizer()->getcode(); //4561
        $codedCode = base64_encode($code);
        //$redirecd(/$codedCode);
        $game = $this->container->get(g11c_mastermind.game);
        return $this->render('g11cMastermindBundle:Default:index.html.twig', array('name' => $name));*/
        return array();
    }
    /*public function gameAction($codedCode)
    {
        $code = Radomizer()->getcode(); //4561
        $codedCode = base64_deencode($codedCode);
       // $redirecd(/$codedCode);
        $game = $this->container->get(g11c_mastermind.game);
        return $this->render('g11cMastermindBundle:Default:index.html.twig', array('name' => $name));
    }*/
}
