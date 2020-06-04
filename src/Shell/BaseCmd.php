<?php

namespace Cmds\Shell;

class BaseCmd
{
    public array $args = [];

    /**
     * This method should be overwritten in shell if args are available
     *
     */
    public function cmdArgs(): array 
    {
        return [];
    }

    /**
     * Prints red text
     */
    public function error(string $s): void
    {
	$l = strlen($s);
        print "\033[01;31m" . $s . "\033[0m";
    }

    /**
     * Prints yellow text                                                                                                    */
    public function warn(string $s): void
    {
        $l = strlen($s);
        print "\033[01;33m" . $s . "\033[0m";
    }

    /**
     * Prints green text
     */
    public function success(string $s): void
    {
        $l = strlen($s);
        print "\033[01;32m" . $s . "\033[0m";
    }	    
}
