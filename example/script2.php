<?php

//php script2.php command subCommand -p 10 -b --param1 11 --param2 --pa -iv "ttt aaa ssss" asdasd

chdir(dirname(dirname(__FILE__)));

include_once('vendor/autoload.php');


function dd($a)
{
    echo "<pre>";
    print_r($a);
    die();
}

$terminal = new Terminal\Request(true);

echo "Script:" . $terminal->getScript() . PHP_EOL;
echo "Command:" . $terminal->getCommand() . PHP_EOL;
echo "SubCommand:" . $terminal->getSubCommand() . PHP_EOL;
foreach ($terminal->getParams() as $paramName => $paramValue) {
    echo "Param $paramName has value '" . ($terminal->getParameter($paramName) === true ? "true" : $terminal->getParameter($paramName)) . "'" . PHP_EOL;
}

dd($terminal->getParams());