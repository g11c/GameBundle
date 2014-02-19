<?php

namespace g11c\GameBundle\Mastermind;

use g11c\GameBundle\Mastermind\GenerateRandomCodeInterface;

class Randomizer implements GenerateRandomCodeInterface
{
    protected $codeLength;
    
    function __construct()
    {
    }
    
    /**
     * Generates a secret string code of numbers (which are here equal as colors) 
     * between 0 and 6. It has a defined lenght and the numbers cannot occur 
     * multiple times.
     * 
     * While the generates secret code has a smaller lenght than defined, it should 
     * go on with generating.
     * A random number between 0 and 6 is given to a container variable. The type is set as 
     * a string. 
     * Then it is checked, if the generated secret code already contains the number 
     * in the current container.
     * If not, it will be add to the secret generated code.
     * 
     * @param type $codeLength
     * @return type
     */
    public function generateCode($codeLength = 4)
    {
        $this->codeLength = $codeLength;
        $generatedCode = "";
        while(strlen($generatedCode) !== $this->codeLength)
        {
            $tempRandomNumberContainer = mt_rand(0, 6);
            settype($tempRandomNumberContainer, "string");
            
            if(strpos($generatedCode, $tempRandomNumberContainer) === false)
            {
                $generatedCode .= $tempRandomNumberContainer;
            }
        }
        return $generatedCode;
    }
}

