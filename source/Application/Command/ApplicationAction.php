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

use UUP\Application\Options\ApplicationOptionsInterface;

abstract class ApplicationAction extends ApplicationBase implements ApplicationInterface
{
    protected ApplicationOptionsInterface $options;

    public function version(): void
    {
        printf("%s v%s\n", $this->getScript(), $this->getVersion());
    }

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

    public function getVersion(): string
    {
        return "0.0.0";
    }
}
