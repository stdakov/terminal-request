# terminalRequest

## Installation

The preferred way to install this tool is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require stdakov/terminalRequest
```

or add

```
"stdakov/terminalRequest": "*"
```


## Usage

```php
require 'vendor/autoload.php';
```
## Examples 
* Command 1
 ```
php script1.php command subCommand -p 10 -b --param1 11 --param2 --pa "ttt aaa ssss" asdasd
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
Script:script1.php
Command:command
SubCommand:subCommand
Param p has value '10'
Param b has value 'true'
Param param1 has value '11'
Param param2 has value 'true'
Param pa has value 'ttt aaa ssss'
<pre>Array
(
    [p] => 10
    [b] => 1
    [param1] => 11
    [param2] => 1
    [pa] => ttt aaa ssss
)

```

* Command2
If you want to use multi short parameters like `-av "value of params v"` you have to set `true` Request constructor

-a will have value true
-v will have value "value of params v"

```
php script2.php command subCommand -p 10 -b --param1 11 --param2 --pa -iv "ttt aaa ssss" asdasd
```

```php

$terminal = new Terminal\Request(true);

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
Script:script2.php
Command:command
SubCommand:subCommand
Param p has value '10'
Param b has value 'true'
Param param1 has value '11'
Param param2 has value 'true'
Param pa has value 'true'
Param i has value 'true'
Param v has value 'ttt aaa ssss'
<pre>Array
(
    [p] => 10
    [b] => 1
    [param1] => 11
    [param2] => 1
    [pa] => 1
    [i] => 1
    [v] => ttt aaa ssss
)

```