<?php

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

    function usage(): void
    {
        $this->action->usage();
        exit(0);
    }

    function execute(): void
    {
        if ($this->getApplicationOptions()->hasOption('help')) {
            $this->usage();
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
