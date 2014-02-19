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
     * Starting mastermind game.
     * 
     * First get mastermind service and session. If the code is not already set in 
     * session a new code has to be generated (happens in row 33) -> this is important
     * for the interaction with user.
     * When the code is generated first, it should not be forgotten, except, when 
     * user wishes to restart.
     * So the secret code will be remembered in the session.
     * 
     * When there is POST in the request, I know, that the user has make his/her turn.
     * Here shoud come the user input validation (TODO).
     * The userinput is given to the method turn(). There it will go through 
     * the code comparing logic.
     * 
     * It is also important to remember turns. The user has to see all his/her turns.
     * The turns will be saved in the sesseion.
     * 
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
