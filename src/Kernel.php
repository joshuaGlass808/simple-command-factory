<?php

namespace Cmds;

use Cmds\Shell\BaseCmd;

class Kernel
{
    public static function classes(): array
    {
        return [
       	    Shell\CreateShell::class,
	    Shell\DesktopImageRotationShell::class
	];
    }
    public static function getCommandClass(string $signature, ?array $args): ?BaseCmd
    {
        $classes = self::classes();

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

    public static function printHelp(): void
    {
        $classes = self::classes();
	print "Usage: ./php-cmd <shell:signature> [--args=...]\n"
	    . "       ./php-cmd -h\n";

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
