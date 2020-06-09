<?php declare(strict_types=1);

namespace SCF\Shell;

use SCF\Logger\Log;
use SCF\Styles\TextColor;

class BaseCmd
{
    public array $args = [];
    protected array $config = [];
    protected array $env = [];

    public function __construct(array $paths = []) 
    {
        if (isset($paths['config'])) {
            $this->config = $paths['config'];
        }

        if (isset($paths['env'])) {
            $this->env = $paths['env'];
        }
    }

    /**
     * This method should be overwritten in shell if args are available
     * 
     * @return array
     */
    public function cmdArgs(): array 
    {
        return $this->argumentMap;
    }

    /**
     * Wrapper around Log so we people don't have to add it to each class they use.
     *  You could just use the inheritted log method.
     * @param string $message - what to log.
     * 
     * @return bool Returns false if failed, true on success.
     */
    public function log(string $message): bool 
    {
        return Log::write($message);
    }

    /**
     * Prints text to terminal, colors optional.
     */
    public function output(string $s, string $color = null): void 
    {
        if ($color === null) {
            print $s;
        } else {
            print $color . $s . TextColor::END;
        }
    }

    /**
     * Prints red text
     * 
     * @param string $s msg
     * 
     * @return void
     */
    public function error(string $s, bool $log = false): void
    {
        $this->output($s, TextColor::RED);

        if ($log) {
            $this->log($s);
        }
    }

    /**
     * Prints yellow text  
     * 
     * @param string $s msg
     * 
     * @return void
     */
    public function warn(string $s, bool $log = false): void
    {
        $this->output($s, TextColor::YELLOW);

        if ($log) {
            $this->log($s);
        }
    }

    /**
     * Prints green text
     * 
     * @param string $s msg
     * 
     * @return void
     */
    public function success(string $s, bool $log = false): void
    {
        $this->output($s, TextColor::GREEN);

        if ($log) {
            $this->log($s);
        }
    }	    
}
