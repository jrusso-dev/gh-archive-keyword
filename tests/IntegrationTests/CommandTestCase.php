<?php


namespace App\Tests\IntegrationTests;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class CommandTestCase extends TestCase
{
    protected function getProcess(array $command): Process
    {
        return new Process(
            $command,
            null,
            ['APP_ENV' => 'integration']
        );
    }
}
