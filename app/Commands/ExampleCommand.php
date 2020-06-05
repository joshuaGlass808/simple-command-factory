<?php

namespace App\Commands;

use SCF\Interfaces\CmdInterface;
use SCF\Shell\BaseCmd;
use SCF\Traits\CmdTrait;

class ExampleCommand extends BaseCmd implements CmdInterface
{
    use CmdTrait;

    public string $signature = 'print:message';

    /**
     * Method is used to correctly parse the args in the 
     *  commandline and for the help message.
     */
    public function cmdArgs(): array 
    {
        return [
            '--message=' => 'Message to be printed',
            '--show'     => 'For boolean style flags, leave out the = at the end. Default is false unless used'
        ];
    }

    /**
     * Method called to run the command.
     */
    public function execute(): void
    {
        // Get started!
        $args = $this->getArgs();
        if ($args['show']) {
            $this->success($args['message'] . "\n");
        }
    }
}
