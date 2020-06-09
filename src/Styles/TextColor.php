<?php declare(strict_types=1);

namespace SCF\Styles;

abstract class TextColor 
{
    /**
     * Not the complete list of ANSI codes.
     */
    const BLACK   = "\033[01;30m";
    const RED     = "\033[01;31m";
    const GREEN   = "\033[01;32m";
    const YELLOW  = "\033[01;33m";
    const BLUE    = "\033[01;34m";
    const MAGENTA = "\033[01;35m";
    const CYAN    = "\033[01;36m";
    const WHITE   = "\033[01;37m";

    /**
     * End ANSI Code to end the color text.
     */
    const END = "\033[0m";
}