<?php declare(strict_types=1);

namespace App\Commands;

use SCF\Contracts\CommandContract;
use SCF\Commands\BaseCommand;
use SCF\Traits\CommandTrait;
use SCF\Styles\TextStyle;

class ExampleCommand extends BaseCommand implements CommandContract
{
    use CommandTrait;

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
            $this->warn("Environment: {$this->env['ENV']}\n");
            $this->warn("Config DB Driver: {$this->config['database-driver']}\n");
            $this->output('Execution took: ' . (microtime(true) - $start) . " seconds\n", TextStyle::CYAN);
        }
    }
}
