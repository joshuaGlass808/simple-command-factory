# PHP-CMD
php-cmd is a lite cli helper. It comes with a command to help boilerplate the creation of more commands.
This was inspired by Laravels Artisan command and the Symfony Command line packages as well. I set out to
try and make my own cli helper (framework?), but with as little to no dependencies.

## Install:
```
git clone https://github.com/joshuaGlass808/php-cmd.git
cd php-cmd/
composer install
```

After that, feel free to start creating commands:
```
./php-cmd create:shell --shell-name='MyCommandsClassname'
```

## Example command class:
```
<?php

namespace Cmds\Shell;

use Cmds\Interfaces\CmdInterface;
use Cmds\Traits\CmdTrait;

class CreateShell extends BaseCmd implements CmdInterface
{
    use CmdTrait;
    
    public string $signature = 'create:shell';
    
    public function cmdArgs(): array
    {
        return [
            '--shell-name=' => 'Name of the Shell you wish to create.',
            '--path=' => 'Default path is location of this file, set this to override it.',
        ];
    }
    
    public function execute(): void
    {
        $args = $this->getArgs();
        $class = $args['shell-name'];
        $classT = "<?php\n\nnamespace Cmds\Shell;\n\n"
            . "use Cmds\\Interfaces\\CmdInterface;\n"
            . "use Cmds\\Traits\\CmdTrait;\n\n"
            . "class {$class} extends BaseCmd implements CmdInterface\n"
            . "{\n    use CmdTrait;\n\n"
            . "    public function execute(): void\n"
            . "    {\n        // Get started!\n    }\n}\n";
        $path = $args['path'] ?? "/src/Shell";
        $file = getcwd() . "{$path}/{$class}.php";
        if (file_exists($file)) {
            print "Class already exists, use a new name.\n";
            exit(1);
        }
        
        $fd = fopen($file, 'x');
        fwrite($fd, $classT);
        fclose($fd);
        print "New class ({$class}) create: {$file}\n";
        print "Don't forget to add {$class} to the Cmds/Kernel class.\n";
    }
}
```

## Example usage:
```
./php-cmd -h
./php-cmd --help
./php-cmd create:shell --shell-name='DesktopImageRotator'

```
Once you register that new shells in the Kernel you will be able to see them inside of the help message

## Example help:
```
./php-cmd -h
Usage: ./php-cmd <shell:signature> [--args=...]
       ./php-cmd -h
    create:shell
        --shell-name= : Name of the Shell you wish to create.
        --path= : Default path is location of this file, set this to override it.

    desktop:image:rotation

Options:
    --help|-h : Display this help message.
```
