<?php

//php script.php command subCommand -a value1 -bc 'value2' --param1 value3 --param2 --pa "value4" --vk value5

chdir(dirname(dirname(__FILE__)));

include_once('vendor/autoload.php');


function dd($a)
{
    echo "<pre>";
    print_r($a);
    die();
}

$terminal = new Terminal\Request();

echo "Script:" . $terminal->getScript() . PHP_EOL;
echo "Command:" . $terminal->getCommand() . PHP_EOL;
echo "SubCommand:" . $terminal->getSubCommand() . PHP_EOL;
foreach ($terminal->getParams() as $paramName => $paramValue) {
    echo "Param $paramName has value '" . ($terminal->getParameter($paramName) === true ? "true" : $terminal->getParameter($paramName)) . "'" . PHP_EOL;
}

if ($terminal->getParameter("a") !== "value1") {
    throw new Exception("Missing or wrong paramerter");
}

if ($terminal->getParameter("b") !== true) {
    throw new Exception("Missing or wrong paramerter");
}

if ($terminal->getParameter("c") !== "value2") {
    throw new Exception("Missing or wrong paramerter");
}

if ($terminal->getParameter("param1") !== "value3") {
    throw new Exception("Missing or wrong paramerter");
}

if ($terminal->getParameter("param2") !== true) {
    throw new Exception("Missing or wrong paramerter");
}

if ($terminal->getParameter("pa") !== "value4") {
    throw new Exception("Missing or wrong paramerter");
}

if ($terminal->getParameter("vk") !== "value5") {
    throw new Exception("Missing or wrong paramerter");
}

dd($terminal->getParams());
