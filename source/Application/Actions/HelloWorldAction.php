<?php

/*
 * Copyright (C) 2021 Anders Lövgren (Nowise Systems).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
