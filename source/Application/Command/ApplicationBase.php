<?php

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
