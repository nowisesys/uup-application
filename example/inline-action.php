<?php

declare(strict_types=1);

namespace UUP\Example\Application;

require_once(__DIR__ . '/../vendor/autoload.php');

use UUP\Application\Command\ApplicationAction;
use UUP\Application\Command\ApplicationRunner;

//
// Example of using inline anonymous class with command option.
//
// Usage:
//
// php inline-anonymous-example.php                     # Hello world, Anders!
// php inline-anonymous-example.php my-name=Bertil      # Hello world, Bertil!
//
// php inline-anonymous-example.php help                # Show usage information
//

(new ApplicationRunner(new class extends ApplicationAction {

    public function usage(): void
    {
        printf("Some short description of script purpose.\n");
        printf("\n");
        printf("Options:\n");
        printf("  my-name:    Set caller name.\n");
        printf("\n");

        parent::usage();
    }

    public function setup(): void
    {
        if ($this->options->isMissing('my-name')) {
            $this->options->setOption('my-name', "Anders");
        }
    }

    public function execute(): void
    {
        if ($this->options->hasOption('my-name')) {
            printf("Hello world, %s!\n", $this->options->getString('my-name'));
        }
    }

}))->execute();
