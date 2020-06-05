<?php

namespace SCF;

class Application
{
    protected array $args = [];

    public function __construct(array $args)
    {
        $this->args = $args;
    }

    /**
     * Runs the command application.
     * 
     * @param bool $logRuns - If this is in production and running on cronjobs / queuing system,
     *   you may want to know when they ran, if so make $logRuns True.
     */
    public function run(bool $logRuns = false): void 
    {
        $command = array_shift($this->args);
        if (preg_match('/^(--help|-h)$/i', $command)) {
            \App\Kernel::printHelp();
            print "Options:\n    --help|-h : Display this help message.\n";
            exit(0);
        }
        
        if (count($this->args) === 0) {
            $this->args = null;
        }
        
        $class = \App\Kernel::getCommandClass($command, $this->args);
        if ($class === null) {
            $error = sprintf(
                "The command: %s is not a valid command listed in the %s class or a valid option.\n", 
                $command, 
                \App\Kernel::class
            );
            print $error;
            // log $error; if $logRuns == true
            exit(3);
        }
        
        $class->execute();
    }
}