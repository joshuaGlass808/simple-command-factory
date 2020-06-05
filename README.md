# Simple Command Framework
scf is a simple, small, lightweight command framework. It comes with a command to help boilerplate the creation of more commands.
This was inspired by Laravels Artisan command and the Symfony Command line packages as well. I set out to
try and make my own cli helper (framework?), but with no dependencies outside of php. Due to that scf has missing features like bindings with ncurses or a graphing/loading library.

## Install:
```
git clone https://github.com/joshuaGlass808/php-cmd.git
cd php-cmd/
composer install
```

After that, feel free to start creating commands:
```
./scf create:shell --shell-name='ExampleCommand' --signature='print:message'
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
            '--message=' => 'Message to be printed',
            '--show'     => 'For boolean style flags, leave out the = at the end. Default is false unless used'
        ];
    }

    /**
     * Method called to run the command.
     */
    public function execute(): void
    {
        // Get started!
        $args = $this->getArgs();
        if ($args['show']) {
            $this->success($args['message'] . "\n");
        }
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

./scf print:message --message='hello world' --show
#
# OUTPUT: hello world

# without the --show flag (apart of the command args), show will default to false and not show the message
./scf print:message --message='hello world'

```
Once you register that new shells in the Kernel you will be able to see them inside of the help message

## Example help:
```
$ ./scf -h
Usage: ./scf <shell:signature> [--args=...]
       ./scf -h

    print:message
        --message= : Message to be printed
        --show : For boolean style flags, leave out the = at the end. Default is false unless used

Options:
    --help|-h : Display this help message.
```

## Documentation
Somethings that may not have been shown in the examples above:
* Colored text in command classes
    * `$this->warn('Outputs yellow text');`
    * `$this->success('Outputs green text');`
    * `$this->error('Outputs red text');`

## Coming Soon
* Parameters added to output functions to also send messages to log files.
    * Possible Example: `$this->error($text, $logFilePath, self::APPEND|self::OVERWRITE);`
* Add ability to use more colors if wanted:
    * Possible example: `$this->output('Some text to display', SCF\Styles\Output::BLUE);`
* A storage directory for keeping anything from cache to command logs.
    * I think it will ship with an empty directory structure and a starter log.
    * when logs are written, it will be written like `scf-<date>.log`. Example: `../storage/logs/scf-20200604.log` (log for June 4th, 2020)
        * Possible config to change the date structure on the files.
        
* Create a `config/` directory and keep config files for specific services, or for future add ons.
