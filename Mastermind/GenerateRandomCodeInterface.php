<?php

namespace g11c\GameBundle\Mastermind;

interface GenerateRandomCodeInterface
{
    /**
     * Generates a secret random code.
     */
    public function generateCode();
}
