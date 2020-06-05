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
            $key = array_shift($argParsed);
            if (in_array($key . '=', $keys)) {
                // imploding with = incase they used the = in the arguments string.
                $args[str_replace('--', '', $key)] = implode('=', $argParsed);
            }

            if (in_array($key, $keys)) {
                $args[str_replace('--', '', $key)] = true;
            }
        }

        // Defaulting all boolean args to false if they are not set.
        foreach ($keys as $key) {
            $cleanKey = str_replace('--', '', $key);
            if ($key[strlen($key)-1] === '=' || isset($args[$cleanKey])) {
                continue;
            }

            $args[$cleanKey] = false;
        }

        return $args;
    }
}
