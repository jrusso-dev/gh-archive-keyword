<?php


namespace App\Tests\IntegrationTests\Data;
use App\Tests\IntegrationTests\CommandTestCase;

/**
 * Class ImportFromGhArchiveTest
 * @package App\Tests\IntegrationTests\Data
 */
class ImportFromGhArchiveTest extends CommandTestCase
{
    const BIN_CONSOLE = 'bin/console';
    const COMMAND = 'commit:import';

    public function testSuccessful()
    {
        $command = [
            self::BIN_CONSOLE,
            self::COMMAND,
            '2020',
            '12',
            '31'
        ];
        $process = $this->getProcess($command);
        $process->run();
        $this->assertTrue($process->isSuccessful());
        $output = $process->getOutput();
        $this->assertTrue(strpos($output, '24 rows imported for date 2020-12-31') !== false);
    }

    public function testSuccessfulWithNoData()
    {
        $command = [
            self::BIN_CONSOLE,
            self::COMMAND,
            '2020',
            '12',
            '01'
        ];
        $process = $this->getProcess($command);
        $process->run();
        $this->assertTrue($process->isSuccessful());
        $output = $process->getOutput();
        $this->assertTrue(strpos($output, '0 rows imported for date 2020-12-01') !== false);
    }

    public function testFailMissingParameter()
    {
        $command = [
            self::BIN_CONSOLE,
            self::COMMAND,
            '2020',
        ];
        $process = $this->getProcess($command);
        $process->run();
        $this->assertFalse($process->isSuccessful());
    }

    public function testFailWrongDateFormat()
    {
        $command = [
            self::BIN_CONSOLE,
            self::COMMAND,
            '2020',
            '11',
            '31',
        ];
        $process = $this->getProcess($command);
        $process->run();
        $this->assertFalse($process->isSuccessful());
    }

    public function testFailFutureDate()
    {
        $command = [
            self::BIN_CONSOLE,
            self::COMMAND,
            '2025',
            '10',
            '01',
        ];
        $process = $this->getProcess($command);
        $process->run();
        $this->assertFalse($process->isSuccessful());
    }

}
