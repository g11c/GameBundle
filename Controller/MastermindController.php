<?php

namespace g11c\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/mastermind")
 */
class MastermindController extends Controller
{
    /**
     * 
     * 
     * @TODO: user input validation
     * @TODO: use symfony2 forms
     * @Route("/")
     * @Template()
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function indexAction(Request $request)
    {
        $mastermind = $this->container->get('g11c_game.mastermind');
        
        $session = $request->getSession();
        $code = $session->get('code', null);
        $code = $mastermind->start(4, $code);
        $session->set('code', $code);
        
        $turns = $session->get("turns", array());
        
        if($request->isMethod('POST')) 
        {
            $userCode = $request->request->get('usercode');
            
            $mastermind->turn($userCode);
            
            $turn['code'] = $userCode;
            $turn['result']['white'] = $mastermind->getRightColorWrongLocation();
            $turn['result']['black'] = $mastermind->getRightLocationAndColor();
            
            $turns[] = $turn;
            
            $session->set('turns', $turns);
        }
        
        return array('mastermind' => $mastermind, 'code' => $code, 'turns' => $turns );
    }
    
    /**
     * Restarts the game.
     *  
     * @Route("/restart")
     * @Template()
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function restartAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('code', null);
        $session->set('turns', array());
        
        return $this->redirect($this->generateUrl('g11c_game_mastermind_index'));
    }
}
