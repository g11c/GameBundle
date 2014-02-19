<?php

namespace g11c\GameBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GameMastermindCommand extends ContainerAwareCommand
{
    /**
     * Create mastermind play command with desription.
     */
    protected function configure()
    {
        $this
            ->setName('g11c:mastermind:play')
            ->setDescription('Mastermind is a codebreaking game. ')
            ->setHelp(<<<EOT
You have to guess which colors/numbers are in which place. 
After every move you get feedback. 0 means, that one place has no right answer. 
Black means, that one color/number is right and in right place. White means, 
that one color is right but not the right place. Enjoy.
EOT
                );
    }

    /**
     * Executes the command. Initializes a new mastermind game.
     * Continues game until user has won or wishes to end (quit) or restart.
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        
        $container = $this->getApplication()->getKernel()->getContainer();
        $mastermind = $container->get('g11c_game.mastermind');
        
        $length = 4;
        $debug = true;
        $newGameText = "<fg=green>New game: </fg=green>";
        
        $output->writeln($newGameText);
        $code = $mastermind->start($length);
        if($debug == true)
        {
            $output->writeln(sprintf("<fg=red>code debug: %s</fg=red>", $code));
        }
        
        while(!$mastermind->won())
        {
            $userinput = $dialog->ask(
                    $output,
                    'Please enter your guess: '
                    );
            if($userinput == "quit" || $userinput == "q")
            {
                break;
            }
            else if($userinput == "restart" || $userinput == "r")
            {
                $mastermind->start($length);
                $output->writeln($newGameText);
                if($debug == true)
                {
                    $output->writeln(sprintf("<fg=red>code debug: %s</fg=red>", $code));
                }
                continue;
            }
            $mastermind->turn($userinput);
            $output->writeln(sprintf("Black: <fg=green>%s</fg=green> White: <fg=yellow>%s</fg=yellow>", $mastermind->getRightColorWrongLocation(), $mastermind->getRightLocationAndColor()));
        }
        if($mastermind->won())
        {
            $output->writeln("<fg=green>Contratulations, you won! :-)</fg=green>");
        }
    }
}

