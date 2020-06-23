![Build](https://github.com/joshuaGlass808/simple-command-factory/workflows/Build/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/scf/simple-command-factory/v)](//packagist.org/packages/scf/simple-command-factory)
[![License](https://poser.pugx.org/scf/simple-command-factory/license)](//packagist.org/packages/scf/simple-command-factory)
[![Total Downloads](https://poser.pugx.org/scf/simple-command-factory/downloads)](//packagist.org/packages/scf/simple-command-factory)

# Simple Command Factory
scf is a simple, small, lightweight command factory. It comes with a command to help boilerplate the creation of more commands, and enough features to get more small tasks completed. Feel free to create issues / contribute!.

### Quick Highlight
* I am using this in some current home projects I work on, so I will make sure to maintain package stablility starting at v1.0.0
* This was inspired by Laravels Artisan command and the Symfony Command line packages as well.

## Install:
```bash
# composer create-project scf/simple-command-factory <app>
composer create-project scf/simple-command-factory simple-command-factory
# or
git clone https://github.com/joshuaGlass808/simple-command-factory.git

cd simple-command-factory/
composer install
```

After that, feel free to start creating commands:
```sh
./scf create:shell --shell-name='ExampleCommand' --signature='print:message'
# or
php scf create:shell --shell-name='ExampleCommand' --signature='print:message'
```
Running the command above will result in this output:
```sh
Building file: simple-command-framework/app/Commands/ExampleCommand.php
New class (test) create: simple-command-framework/app/Commands/ExampleCommand.php
Don't forget to add ExampleCommand to the App/Kernel class.
```
Which creates a file like this:
```php
<?php

namespace App\Commands;

use SCF\Interfaces\CmdInterface;
use SCF\Shell\BaseCmd;
use SCF\Traits\CmdTrait;

class ExampleCommand extends BaseCmd implements CmdInterface
{
    use CmdTrait;

    public string $signature = 'print:message';
    public array $argumentMap = [];

    public function execute(): void
    {
        // Get started!
    }
}
```
## Example command class:
This repo ships with an example command already set up in the `App\Commands` namespace.
Feel free to use it!
```php
<?php declare(strict_types=1);

namespace App\Commands;

use SCF\Interfaces\CmdInterface;
use SCF\Shell\BaseCmd;
use SCF\Traits\CmdTrait;
use SCF\Styles\TextColor;

class ExampleCommand extends BaseCmd implements CmdInterface
{
    use CmdTrait;

    public string $signature = 'print:message';
    public array $argumentMap = [
        '--message=' => 'Message to be printed',
        '--show'     => 'For boolean style flags, leave out the = at the end. Default is false unless used'
    ];

    /**
     * Method called to run the command.
     */
    public function execute(): void
    {
        // Get started!
        $start = microtime(true);
        $args = $this->getArgs();
        if ($args['show']) {
            $start = microtime(true);
            $this->success("Message: {$args['message']}\n");
        }
        $this->warn("Environment: {$this->env['ENV']}\n");
        $this->warn("Config DB Driver: {$this->config['database-driver']}\n");
        $this->output('Execution took: ' . (microtime(true) - $start) . " seconds\n", TextColor::CYAN);
    }
}
```
Before we can use this, make sure we register it in `App\Kernel`.
In Kernel.php:
```php
use App\Commands\ExampleCommand;
```
...
```php
    public static function classes(): array
    {
        return [
            ExampleCommand::class,
        ];
    }
```

## Example usage:
```sh
./scf -h
./scf --help
./scf create:shell --shell-name='DesktopImageRotator'

./scf print:message --message='hello world' --show
#
# OUTPUT: hello world

# without the --show flag, show will default to false and not show the message
./scf print:message --message='hello world'

```
Once you register that new shells in the Kernel you will be able to see them inside of the help message

## Example help:
```sh
$ ./scf -h
Usage: ./scf <shell:signature> [--args=...]
       ./scf -h

    create:shell
        --path= : override default path (app/Commands/).
        --shell-name= : Name of the Shell you wish to create.
        --signature= : override default signature

    print:message
        --message= : Message to be printed
        --show : For boolean style flags, leave out the = at the end. Default is false unless used

Options:
    --help|-h : Display this help message.
```

## Documentation
Somethings that may not have been shown in the examples above:

![demo](https://user-images.githubusercontent.com/10493764/84108904-35448580-a9d6-11ea-8fd3-cb435d6baa4d.png)

* Colored text in command classes
    * `$this->output('string', TextColor::CYAN);`
    * `$this->warn('Outputs yellow text');`
    * `$this->success('Outputs green text');`
    * `$this->error('Outputs red text');`
    * `$this->error('String', true); // True will log the string as well`


## Coming Soon
* A way to set command line arguments as required and some sort of type inforcer to some extent.
* May create a new package called scf-application and move everything from src/ inside there. Then load it into scf/scf via composer require.


