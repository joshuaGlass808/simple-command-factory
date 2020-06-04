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
            '--message=' => 'Message to be printed'
        ];
    }

    /**
     * Method called to run the command.
     */
    public function execute(): void
    {
        // Get started!
        $this->success($this->getArgs()['message'] . "\n");
    }
}
