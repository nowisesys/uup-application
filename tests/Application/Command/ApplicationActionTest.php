<?php

namespace UUP\Tests\Application\Command;

use PHPUnit\Framework\TestCase;
use UUP\Application\Command\ApplicationAction;
use UUP\Application\Options\ApplicationOptionsInterface;
use UUP\Application\Options\CommandLineOptions;

class MyApplicationAction extends ApplicationAction
{
    public function __construct()
    {
        $this->options = new CommandLineOptions();
        $this->options->setOptions([]);
    }
}

class ApplicationActionTest extends TestCase
{
    public function testGetApplicationOptions()
    {
        $action = new MyApplicationAction();

        $this->assertIsObject($action->getApplicationOptions());
        $this->assertInstanceOf(ApplicationOptionsInterface::class, $action->getApplicationOptions());
        $this->assertEmpty($action->getApplicationOptions()->getOptions());
    }

    public function testSetApplicationOptions()
    {
        $expect = new CommandLineOptions();

        $action = new MyApplicationAction();
        $action->setApplicationOptions($expect);

        $this->assertIsObject($action->getApplicationOptions());
        $this->assertInstanceOf(ApplicationOptionsInterface::class, $action->getApplicationOptions());
        $this->assertNotEmpty($action->getApplicationOptions()->getOptions());
        $this->assertSame($expect, $action->getApplicationOptions());
    }

    public function testGetScript()
    {
        $action = new MyApplicationAction();

        $this->assertNotEmpty($action->getScript());
        $this->assertEquals('phpunit', $action->getScript());
    }

    public function testAddApplicationOption()
    {
        $action = new MyApplicationAction();
        $action->addApplicationOption('user', 'adam');

        $this->assertNotEmpty($action->getApplicationOptions()->getOption('user'));
        $this->assertEquals('adam', $action->getApplicationOptions()->getOption('user'));
    }
}
