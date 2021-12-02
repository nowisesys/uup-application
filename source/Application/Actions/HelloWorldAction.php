<?php

declare(strict_types=1);

namespace UUP\Application\Actions;

use UUP\Application\Command\ApplicationAction;

//
// Example greeter action class (example template class).
//

class HelloWorldAction extends ApplicationAction
{
    public function usage(): void
    {
        printf("Sample greeter action class.\n");
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
}
