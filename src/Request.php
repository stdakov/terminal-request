<?php

namespace Terminal;

/**
 * Class Request
 * @package Terminal
 * @author Stanislav Dakov st.dakov@gmail.com
 */
class Request
{
    /** @var string $command */
    protected $command;
    /** @var string $subCommand */
    protected $subCommand;
    /** @var array $params */
    protected $params = [];
    /** @var string $script */
    protected $script;
    /** @var bool $allowMultiShort */
    protected $allowMultiShort = false;

    /**
     * Request constructor.
     * @param bool $allowMultiShort
     */
    public function __construct($allowMultiShort = false)
    {
        $this->allowMultiShort = $allowMultiShort;
        $this->parse($_SERVER['argv']);
    }

    /**
     * @return string
     */
    public function getSubCommand()
    {
        return $this->subCommand;
    }

    /**
     * @param string $subCommand
     * @return $this
     */
    protected function setSubCommand($subCommand)
    {
        $this->subCommand = $subCommand;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter($name)
    {
        if (!is_string($name)) {
            return null;
        }

        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setParameter($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException("Wrong parameter name '" . $name . "'");
        }

        if (array_key_exists($name, $this->params)) {
            throw new \InvalidArgumentException("Parameter name '" . $name . "' has already been set");
        }

        $this->params[$name] = $value;

        return $this;
    }


    /**
     * @param array $params
     * @return $this
     */
    protected function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param string $command
     * @return $this
     */
    protected function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get base command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return string The script that has been executed
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Parse the arguments into meaningful command and subCommand.
     * @param array $arguments
     * @throws \Exception
     */
    protected function parse(array $arguments)
    {
        if (!count($arguments)) {
            throw new \Exception("Missing arguments");
        }

        //first we get the script
        $this->script = array_shift($arguments);

        //check for command
        if (strpos(current($arguments), '-') !== 0) {
            //  first one is the command
            $this->setCommand(array_shift($arguments));
        }

        //check for subCommand
        if (strpos(current($arguments), '-') !== 0) {
            //  first one is the command
            $this->setSubCommand(array_shift($arguments));
        }

        $this->parseParams($arguments);
    }

    protected function parseParams($arguments)
    {
        $params           = [];
        $currentParamName = null;

        foreach ($arguments as $argument) {

            if (strpos($argument, "-") === 0) {
                if ($currentParamName != null) {
                    $this->setParameter($currentParamName, true);
                }

                $currentParamName = ltrim(trim($argument), '-');


                if (strpos($argument, "--") === 0) {
                    if (strlen($currentParamName) < 2) {
                        throw new \InvalidArgumentException("The long parameter '" . $currentParamName . "' has wrong name! Must have more than 1 letter!");
                    }

                    continue;
                }

                if (strlen($currentParamName) > 1 && !$this->allowMultiShort) {
                    throw new \InvalidArgumentException("The short parameter '" . $currentParamName . "' has wrong name! Must have 1 letter!");
                }

                if (strlen($currentParamName) > 1 && $this->allowMultiShort) {
                    $combinedParameters = str_split($currentParamName);
                    //  the last one takes parameters
                    $currentParamName = array_pop($combinedParameters);

                    foreach ($combinedParameters as $combinedParam) {
                        $params[$combinedParam] = true;
                        $this->setParameter($combinedParam, true);
                    }
                }

                continue;
            }

            //  parameter value
            if ($currentParamName != null) {
                $this->setParameter($currentParamName, trim($argument));
                $currentParamName = null;
                continue;
            }
        }
    }
}
