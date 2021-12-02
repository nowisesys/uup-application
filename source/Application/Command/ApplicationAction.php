<?php

declare(strict_types=1);

namespace UUP\Application\Command;

use UUP\Application\Options\ApplicationOptionsInterface;

abstract class ApplicationAction extends ApplicationBase implements ApplicationInterface
{
    protected ApplicationOptionsInterface $options;

    public function setApplicationOptions(ApplicationOptionsInterface $options): void
    {
        $this->options = $options;
    }

    public function addApplicationOption(string $name, $value): void
    {
        $this->options->setOption($name, $value);
    }

    public function getApplicationOptions(): ApplicationOptionsInterface
    {
        return $this->options;
    }

    public function getScript(): string
    {
        return $this->options->getScript();
    }
}
