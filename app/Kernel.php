<?php declare(strict_types=1);

namespace App;

use App\Commands\ExampleCommand;
use SCF\Contracts\KernelContract;
use SCF\Traits\KernelTrait;

use SCF\Commands\{
	BaseCommand,
    CreateCommand
};

class Kernel implements KernelContract
{
    use KernelTrait;

	/**
	 * Register your Commands here.
	 */
	const COMMANDS = [
        CreateCommand::class,
		ExampleCommand::class,
	];

    /**
     * Classes is a method were you register all the command classes.
     * They be from any namespace as long as they implement 
     *   extend BaseCommand and have an execute method.
     * 
     * @return array - an array of all registered commands.
     */
    public static function classes(): array
    {
		return self::COMMANDS;
    }
	
    /**
     * Get the class instance of the command.
     * 
     * @param string $signature - The command signature <basic:signature:block>
     * @param null|array $args  - Arguments passed with the command at run time.
     * @return null|BaseCommand     - Returns a Cmd class or null if not registered.
     */
    public static function getCommandClass(string $signature, ?array $args, array $env, array $config): ?BaseCommand
    {
        $classes = self::classes();
        $classSignatures = [];
        foreach ($classes as $class) {	    
            if ((new $class)->signature !== $signature) {
                continue;
            }

            $cmd = (new $class);
            if ($args !== null) {
                $cmd->args = $args;
                $cmd->env = $env;
                $cmd->config = $config;
            }
				
            return $cmd;
        }
        
        return null;
    }
}
