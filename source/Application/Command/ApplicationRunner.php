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

namespace UUP\Application\Command;

use Throwable;
use UUP\Application\Options\ApplicationOptionsInterface;
use UUP\Application\Options\CommandLineOptions;
use UUP\Application\Options\HttpRequestOptions;

class ApplicationRunner extends ApplicationBase implements ApplicationInterface
{
    private ApplicationAction $action;

    public function __construct(ApplicationAction $action)
    {
        $this->action = $action;
        $this->action->setApplicationOptions($this->getApplicationOptions());
    }

    public function usage(): void
    {
        $this->action->usage();
        exit(0);
    }

    public function version(): void
    {
        $this->action->version();
        exit(0);
    }

    public function execute(): void
    {
        if ($this->getApplicationOptions()->hasOption('help')) {
            $this->usage();
        }
        if ($this->getApplicationOptions()->hasOption('version')) {
            $this->version();
        }
        if ($this->getApplicationOptions()->hasOption('quiet')) {
            $this->startQuietMode();
        }

        try {
            $this->action->setup();
            $this->action->execute();
        } catch (Throwable $throwable) {
            $this->action->error($throwable);
        } finally {
            $this->action->cleanup();
        }

        if ($this->getApplicationOptions()->hasOption('quiet')) {
            $this->finishedQuietMode();
        }
    }

    public function getApplicationOptions(): ApplicationOptionsInterface
    {
        if (php_sapi_name() == 'cli') {
            return new CommandLineOptions();
        } else {
            return new HttpRequestOptions();
        }
    }

    private function startQuietMode(): void
    {
        ob_start();
    }

    private function finishedQuietMode()
    {
        ob_end_clean();
    }
}
