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

abstract class ApplicationBase implements ApplicationInterface
{
    function usage(): void
    {
        printf("Generic options:\n");
        printf("  help:     Show this casual help.\n");
        printf("  verbose:  Run in verbose mode.\n");
        printf("  quiet:    Run in quiet mode.\n");
        printf("  debug:    Enable debug output.\n");
    }

    function setup(): void
    {
        // ignore
    }

    function execute(): void
    {
        // ignore
    }

    function cleanup(): void
    {
        // ignore
    }

    function error(Throwable $throwable): void
    {
        if ($this->getApplicationOptions()->isMissing('quiet')) {
            $this->showThrowableError("Error", $throwable);
        }
        if ($this->getApplicationOptions()->isMissing('quiet') && $throwable->getPrevious()) {
            $this->showThrowableError("Inner", $throwable->getPrevious());
        }
        if ($this->getApplicationOptions()->hasOption('debug')) {
            $this->showThrowableTrace("Trace", $throwable);
        }
    }

    abstract public function getApplicationOptions(): ApplicationOptionsInterface;

    private function showThrowableError(string $prefix, Throwable $throwable)
    {
        fprintf(STDERR, "%s: Trapped %s (%s [Code:%d])\n",
            $prefix, get_class($throwable), $throwable->getMessage(), $throwable->getCode()
        );
    }

    private function showThrowableTrace(string $prefix, Throwable $throwable)
    {
        fprintf(STDERR, "%s:\n%s\n", $prefix, $throwable->getTraceAsString());
    }
}
