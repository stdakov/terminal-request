# terminalRequest

## Installation

The preferred way to install this tool is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require stdakov/terminal-request
```

or add

```
"stdakov/terminal-request": "*"
```

## Usage

```php
require 'vendor/autoload.php';
```

## Examples

```bash
php script.php command subCommand -a value1 -bc 'value2' --param1 value3 --param2 --pa "value4" --vk value5
```

```php

$terminal = new Terminal\Request();

echo "Script:" . $terminal->getScript() . PHP_EOL;
echo "Command:" . $terminal->getCommand() . PHP_EOL;
echo "SubCommand:" . $terminal->getSubCommand() . PHP_EOL;
foreach ($terminal->getParams() as $paramName => $paramValue) {
    echo "Param $paramName has value '" . ($terminal->getParameter($paramName) === true ? "true" : $terminal->getParameter($paramName)) . "'" . PHP_EOL;
}

print_r($terminal->getParams());
```

Output

```
Script:script.php
Command:command
SubCommand:subCommand
Param a has value 'value1'
Param b has value 'true'
Param c has value 'value2'
Param param1 has value 'value3'
Param param2 has value 'true'
Param pa has value 'value4'
Param vk has value 'value5'
<pre>Array
(
    [a] => value1
    [b] => 1
    [c] => value2
    [param1] => value3
    [param2] => 1
    [pa] => value4
    [vk] => value5
)
```
