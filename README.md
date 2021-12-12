UUP-APPLICATION
==========================================

Run the same command action both for CLI command line and HTTP requests with monitoring.

### ACTIONS:

The action class handles business logic and the runner executes and monitor the action. 

#### Example

```php
<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../vendor/autoload.php');

use MyApp\Actions\ModelGeneratorAction;
use UUP\Application\Command\ApplicationRunner;

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

### INLINE:

For simple tasks, use an anonymous (java-style) class with implementations of wanted methods:

```php
<?php

declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use UUP\Application\Command\ApplicationAction;
use UUP\Application\Command\ApplicationRunner;

(new ApplicationRunner(new class extends ApplicationAction {

    public function execute(): void
    {
        // TODO: Implement the business logic for script (this method is required).
    }

}))->execute();
```

See [example](example) directory for code examples.
