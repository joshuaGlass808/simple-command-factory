<?php

namespace SCF\Traits;

trait CmdTrait 
{
    /**
     * Get the Arguments in a easy to read array.
     * 
     * @return array
     */
    protected function getArgs(): array
    {
        $args = [];
        $keys = array_keys($this->cmdArgs());

        foreach ($this->args as $arg) {
            $argParsed = explode('=', $arg);
            if (in_array($argParsed[0] . '=', $keys)) {
                $args[str_replace('--', '', $argParsed[0])] = $argParsed[1];
            }
        }

        return $args;
    }
}
