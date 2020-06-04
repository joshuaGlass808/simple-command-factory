<?php

namespace SCF\Shell;

class BaseCmd
{
    public array $args = [];

    /**
     * This method should be overwritten in shell if args are available
     * 
     * @return array
     */
    public function cmdArgs(): array 
    {
        return [];
    }

    /**
     * Prints red text
     * 
     * @param string $s msg
     * 
     * @return void
     */
    public function error(string $s): void
    {
        $l = strlen($s);
        print "\033[01;31m" . $s . "\033[0m";
    }

    /**
     * Prints yellow text  
     * 
     * @param string $s msg
     * 
     * @return void
     */
    public function warn(string $s): void
    {
        $l = strlen($s);
        print "\033[01;33m" . $s . "\033[0m";
    }

    /**
     * Prints green text
     * 
     * @param string $s msg
     * 
     * @return void
     */
    public function success(string $s): void
    {
        $l = strlen($s);
        print "\033[01;32m" . $s . "\033[0m";
    }	    
}
