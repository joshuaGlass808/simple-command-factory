<?php

class AppTest extends \Orchestra\Testbench\TestCase
{
    public function testApplication(): void 
    {
        $command = [
            'print:message',
            '--message=test'
        ];
        $env = [
            'ENV' => 'testing'
        ];
        $config = [
            'database-driver' => 'testing'
        ];
        $app = (new \SCF\CommandApplication($command, $env, $config))
            ->run(false); 
        
        $this->assertTrue($app);
    }
}