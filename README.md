UUP-APPLICATION - Run monitored action
==========================================

Classes for running monitored command. Supports running same action both from CLI and HTTP requests.

### ACTIONS:

The action class handles business logic and the runner executes and monitor the action. 

#### Example

```php
<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Application\Actions\Generate\Model\GeneratorAction as ModelGeneratorAction;
use App\Application\ApplicationRunner;

$action = new ModelGeneratorAction();
$runner = new ApplicationRunner($action);
$runner->execute();
```

### LIFETIME:

The action class derives from `ApplicationAction` and implements the lifetime methods `usage()`, `setup()`, 
`execute()` and `cleanup()`. At least the setup method should be implemented, the other are optional.

### OPTIONS:

Command options are passed from CLI command options or HTTP request depending on execution context. The runner takes
are of handling help or quiet options.

### MONITOR:

The runner execute the action class and provides error monitoring. By default, runner will terminate action when a 
throwable get caught. The error behavior can be overridden by action class.
