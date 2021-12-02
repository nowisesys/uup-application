<?php

declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use UUP\Application\Command\ApplicationAction;
use UUP\Application\Command\ApplicationRunner;

//
// Action runner template using an inline anonymous class.
//

(new ApplicationRunner(new class extends ApplicationAction {

    public function usage(): void
    {
        // TODO: Fill in script purpose and non-standard options (this method is optional).

        parent::usage();    // Output standard options
    }

    public function setup(): void
    {
        // TODO: Initialization code goes here (this method is optional).
    }

    public function execute(): void
    {
        // TODO: Implement the business logic for script (this method is required).
    }

}))->execute();
