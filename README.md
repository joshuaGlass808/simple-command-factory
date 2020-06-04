# Simple Command Framework
scf is a simple, small, lightweight command framework. It comes with a command to help boilerplate the creation of more commands.
This was inspired by Laravels Artisan command and the Symfony Command line packages as well. I set out to
try and make my own cli helper (framework?), but with no dependencies. Due to that scf has missing features like bindings with ncurses or a graphing/loading library.

## Install:
```
git clone https://github.com/joshuaGlass808/php-cmd.git
cd php-cmd/
composer install
```

After that, feel free to start creating commands:
```
./scf create:shell --shell-name='MyCommand' --signature='custom:signature:block'
```

## Example command class:
This repo ships with an example command already set up in the `App\Commands` namespace.
Feel free to use it!

```
<?php

namespace App\Commands;

use SCF\Interfaces\CmdInterface;
use SCF\Shell\BaseCmd;
use SCF\Traits\CmdTrait;

class ExampleCommand extends BaseCmd implements CmdInterface
{
    use CmdTrait;

    public string $signature = 'print:message';

    /**
     * Method is used to correctly parse the args in the 
     *  commandline and for the help message.
     */
    public function cmdArgs(): array 
    {
        return [
            '--message=' => 'Message to be printed'
        ];
    }

    /**
     * Method called to run the command.
     */
    public function execute(): void
    {
        // Get started!
        $this->success($this->getArgs()['message'] . "\n");
    }
}
```
Before we can use this, make sure we register it in `App\Kernel`.
In Kernel.php:
```
use App\Commands\ExampleCommand;
```
...
```
    public static function classes(): array
    {
        return [
            ExampleCommand::class,
        ];
    }
```

## Example usage:
```
./scf -h
./scf --help
./scf create:shell --shell-name='DesktopImageRotator'

```
Once you register that new shells in the Kernel you will be able to see them inside of the help message

## Example help:
```
./scf -h
Usage: ./scf <shell:signature> [--args=...]
       ./scf -h

    create:shell
        --shell-name= : Name of the Shell you wish to create.
        --path= : Default path is location of this file, set this to override it.

    desktop:image:rotation

Options:
    --help|-h : Display this help message.
```
