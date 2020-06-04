<?php

namespace SCF\Shell;

use SCF\Interfaces\CmdInterface;
use SCF\Traits\CmdTrait;

class CreateShell extends BaseCmd implements CmdInterface
{
    use CmdTrait;

    public string $signature = 'create:shell';

    /**
     * Set Command arguments
     * 
     * @return array
     */
    public function cmdArgs(): array 
    {
        return [
            '--path=' => 'override default path (app/Commands/).',
            '--shell-name=' => 'Name of the Shell you wish to create.',
            '--signature=' => 'override default signature',
	    ];
    }

    /**
     * Execute Command = Creates a new Command Class file.
     * 
     * @return void
     */
    public function execute(): void
    {
        $args = $this->getArgs();
        $class = $args['shell-name'];
        $path = $args['path'] ?? "/app/Commands";
        $file = getcwd() . "{$path}/{$class}.php";
        $this->warn("Building file: {$file}\n");

        if (file_exists($file)) {
            print "Class already exists, use a new name.\n";
            exit(1);
        }

        $fd = fopen($file, 'x');
        fwrite($fd, $this->getClassTemplate($class, $args['signature']));
        fclose($fd);

        $this->success("New class ({$class}) create: {$file}\n");
        $this->warn("Don't forget to add {$class} to the App/Kernel class.\n");
    }
	
    /**
     * Returns the class template as a string.
     * 
     * @param string $class - Class namespace of running command.
     * @param null|string $signature - Class signature.
     * 
     * @return string
     */
    protected function getClassTemplate(string $class, ?string $signature): string 
    {
        return "<?php\n\nnamespace App\Commands;\n\n"
            . "use SCF\\Interfaces\\CmdInterface;\n"
            . "use SCF\\Shell\\BaseCmd;\n"
            . "use SCF\\Traits\\CmdTrait;\n\n"
            . "class {$class} extends BaseCmd implements CmdInterface\n"
            . "{\n    use CmdTrait;\n\n"
            . "    public string \$signature = '" . $signature . "';\n\n"
            . "    public function execute(): void\n"
            . "    {\n        // Get started!\n    }\n}\n";
    }
}
