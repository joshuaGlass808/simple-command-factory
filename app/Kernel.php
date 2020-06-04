<?php

namespace App;

use App\Commands\ExampleCommand;

use SCF\Shell\{
	BaseCmd,
	CreateShell
};

class Kernel
{
    /**
     * Classes is a method were you register all the command classes.
     * They be from any namespace as long as they implement 
     *   extend BaseCmd and have an execute method
     * 
     * @return array - an array of all registered commands.
     */
    public static function classes(): array
    {
        return [
            ExampleCommand::class,
        ];
    }
	
    /**
     * Get the class instance of the command.
     * 
     * @param string $signature - The command signature <basic:signature:block>
     * @param null|array $args  - Arguments passed with the command at run time.
     * @return null|BaseCmd     - Returns a Cmd class or null if not registered.
     */
    public static function getCommandClass(string $signature, ?array $args): ?BaseCmd
    {
        $classes = self::classes();
        // I don't want CreateShell to be accidentally removed.
        // I felt it was a useful command. If programmer doesn't like it,
        // feel free to remove from commands lists.
        $classes[] = CreateShell::class;
        $classSignatures = [];
        foreach ($classes as $class) {	    
            if ((new $class)->signature === $signature) {
                $cmd = (new $class);
                if ($args !== null) {
                    $cmd->args = $args;
                }
				
                return $cmd;
            }
        }
        
        return null;
    }

    /**
     * Display Help Message.
     * 
     * @return void
     */
    public static function printHelp(): void
    {
        $classes = self::classes();
        print "Usage: ./scf <shell:signature> [--args=...]\n"
            . "       ./scf -h\n\n";

        foreach ($classes as $class) {
            $c = new $class;
            $s = '    ';
            print $s . $c->signature . "\n";
            foreach ($c->cmdArgs() as $arg => $desc) {
                print $s . $s . $arg . ' : ' . $desc . "\n";
            }
            print "\n";
        }
    }
}
