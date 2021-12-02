<?php

declare(strict_types=1);

namespace UUP\Example\Application;

require_once(__DIR__ . '/../vendor/autoload.php');

use UUP\Application\Actions\HelloWorldAction;
use UUP\Application\Command\ApplicationRunner;

$action = new HelloWorldAction();
$runner = new ApplicationRunner($action);
$runner->execute();
