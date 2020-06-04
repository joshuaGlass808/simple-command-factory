<?php

namespace Cmds\Traits;

trait CmdTrait 
{
    protected function getArgs(): array
    {
        $args = [];
        $cmdsArgs = $this->cmdArgs();
        foreach ($this->args as $arg) {
            $keys = array_keys($cmdsArgs);
	    $argParsed = explode('=', $arg);
	    $this->error("Error test\n");
	    $this->warn("Warn test\n");
	    $this->success("Success test\n");
            if (in_array($argParsed[0] . '=', $keys)) {
                $args[str_replace('--', '', $argParsed[0])] = $argParsed[1];
            }

        }

	return $args;
    }
}
