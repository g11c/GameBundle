<?php

namespace g11c\GameBundle\Mastermind;

use g11c\GameBundle\Mastermind\GenerateRandomCodeInterface;

class Mastermind
{   
    protected $randomizer;
    protected $code;
    protected $codeLength;
    protected $resultsBlack = array();
    protected $resultsWhite = array();
    
    /**
     * Set given radomizer
     * 
     * @param \g11c\GameBundle\Mastermind\GenerateRandomCodeInterface $randomizer
     */
    function __construct(GenerateRandomCodeInterface $randomizer)
    {
        $this->randomizer = $randomizer;
    }
    
    /**
     * Readable view of Mastermind results
     * 
     * @return String
     */
    function __toString() 
    {
        return "Black: ".$this->resultsBlack.", White: ".$this->resultsWhite;
    }
    
    /**
     * Returns how many have the right color and are at right position
     * 
     * @return int
     */
    public function getRightLocationAndColor()
    {
        return $this->getResultsofArray($this->resultsBlack);
    }
    
    /**
     * Returns how many have the right color, but are at the wrong position
     * 
     * @return int
     */
    public function getRightColorWrongLocation()
    {
        return $this->getResultsofArray($this->resultsWhite);
    }
    
    /**
     * Goes through array and adds values
     * 
     * @param type $resultArray
     * @return int
     */
    private function getResultsofArray($resultArray)
    {
        $resultsContainer = 0;
        foreach($resultArray as $value)
        {
           $resultsContainer = $resultsContainer + $value; 
        }
        return $resultsContainer;
    }
    
    /**
     * Starts the game: 
     * Results of last game will be resetted. 
     * A new secret code will be generated. 
     * 
     * @param type $codeLength
     * @param type $code
     * @return type
     */
    public function start($codeLength = 4, $code = null)
    {
        $this->codeLength = $codeLength;
        $this->resetResult(); //this could be drop, because it happens before every turn
        if($code === null)
        {
            $this->code = $this->randomizer->generateCode();
        }
        else
        {
            $this->code = $code;
        }
        
        return $this->code;
    }
    
    /**
     * Resets the results of the last turn
     */
    private function resetResult()
    {
        $this->resultsBlack = array();
        $this->resultsWhite = array();
    }
    
    /*
     * one game turn: 
     * first results of last turn have to be reset
     * userinput has to be validated
     * then the userinput will be compared with the secret code
     */
    
    
    /**
     * One game turn: 
     * First results of last turn have to be reset.
     * TODO: Userinput has to be validated
     * Then the userinput will be compared with the secret code
     * 
     * @param type $userinput
     * @throws Exception
     */
    public function turn($userinput)
    {
        $this->resetResult();
        if(!$this->userinputValidation())
        {
            throw new Exception('Userinput not valid');
        }
        $this->compareWithCode($userinput);
    }
    
    /**
     * TODO: User input Validation (is it a string containing numbers?)
     * @return boolean
     */
    private function userinputValidation()
    {
        return true;
    }
    
    /**
     * Check first, if the color is right and at right position
     * Then, if the color is right but at the wrong position
     * 
     * @param type $userinput
     */
    private function compareWithCode($userinput)
    {
        $this->isRightColorAndPosition($userinput);
        $this->isRightColorButWrongPosition($userinput);
    }
    
    /**
     * Check, if the color is right and at right position:
     * For that, go through every position of userinput and compare for the same position
     * in the secret code, if colors are the same.
     * If they are the same, the black result array gets a "true" for that position.* 
     * 
     * @param type $userinput
     */
    private function isRightColorAndPosition($userinput)
    {
        for($i = 0; $i < strlen($userinput); $i++)
        {
            if($this->code[$i] == $userinput[$i])
            {
                $this->resultsBlack[$this->code[$i]] = 1;
            }
        }
    }
    
    /**
     * Check, if the color is right but at the wrong position:
     * For that, take every position, one after another, from the userinput and
     * compare each with every color of the secret code.
     * If the colors are the same and are not set yet in the black results array, 
     * the current position can be set "true" in the white result array.
     *  
     * @param type $userinput
     */
    private function isRightColorButWrongPosition($userinput)
    {
        for($i = 0; $i < strlen($userinput); $i++)
        {
            for($j = 0; $j < strlen($userinput); $j++)
            {
                if($userinput[$i] == $this->code[$j])
                {
                    if(empty($this->resultsBlack[$this->code[$j]]))
                    {
                        $this->resultsWhite[$this->code[$j]] = 1;
                    }
                }
            }
        }
    }
    
    /**
     * Checks, if the secret code is broken.
     * User has won, when the black result array has as many results set to "true",
     * as the secret code length is. 
     * 
     * @return boolean
     */
    public function won()
    {
        if(count($this->resultsBlack) == $this->codeLength)
        {
            return true;
        }
        return false;
    }
}


