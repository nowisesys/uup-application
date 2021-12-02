<?php

declare(strict_types=1);

namespace UUP\Application\Command;

use Throwable;

interface ApplicationInterface
{
    function usage(): void;

    function setup(): void;

    function execute(): void;

    function cleanup(): void;

    function error(Throwable $throwable): void;
}
