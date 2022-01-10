UUP-APPLICATION
==========================================

Run the same command action both for CLI command line and HTTP requests with monitoring.

### ACTIONS:

The action class handles business logic and the runner executes and monitor the action. 

#### Example

```php
<?php

declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use UUP\Application\Actions\HelloWorldAction;
use UUP\Application\Command\ApplicationRunner;

$action = new HelloWorldAction();
$runner = new ApplicationRunner($action);
$runner->execute();

```

### LIFETIME:

The action class derives from `ApplicationAction` and implements the lifetime methods `usage()`, `setup()`, 
`execute()` and `cleanup()`. At least the setup method should be implemented, the other are optional.

```php
class HelloWorldAction extends ApplicationAction
{
    public function setup(): void
    {
        if ($this->options->isMissing('my-name')) {
            $this->options->setOption('my-name', "Anders");
        }
    }

    public function execute(): void
    {
        if ($this->options->hasOption('my-name')) {
            printf("Hello world, %s!\n", $this->options->getString('my-name'));
        }
    }
}
```

### OPTIONS:

Command options are passed from CLI command options or HTTP request depending on execution context. The runner takes
are of handling help or quiet options. The standard options `help`, `version` and `quiet` are transparent handled along 
with their short option equivalents.

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

### INFORMATION:

Provide `help` and `version` information by overriding base class methods in your action class.

#### HELP

Override the `usage()` method. Call parent method to output standard options.

```php
class HelloWorldAction extends ApplicationAction
{
    public function usage(): void
    {
        printf("Sample greeter action class.\n");
        printf("\n");
        printf("Options:\n");
        printf("  my-name:    Set caller name.\n");
        printf("\n");

        parent::usage();
    }

    ...
}
```

#### VERSION

Similar to usage, but override the `version()` instead. This method gives full control of version output.

```php
class HelloWorldAction extends ApplicationAction
{
    public function version(): void
    {
        printf("hello-world %s\n", $this->getVersion());
    }

    public function getVersion(): string
    {
        return "1.2.2";
    }

    ...
}
```

If default version format is OK, then overriding the `getVersion()` method should be sufficient. 

#### ZERO MAINTENANCE:

**Hint:** Consider reading version string from your package composer.json file instead of using a hard coded string 
that requires manual update!
