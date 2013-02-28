<?php

class Chainable
{
    private $instance;
    private $returns;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $args = func_get_args();
        $obj  = array_shift($args);
        $this->instance = is_object($obj) ? $obj : new $obj($args);
        $this->__resetReturns();
    }

    /**
     * PHP magic method
     *
     * @param string $method method name
     * @param array  $args   method arguments
     * @return Chainable
     */
    public function __call($method, $args)
    {
        $this->returns[$method] = call_user_func_array(array($this->instance, $method), $args);
        return $this;
    }

    /**
     * Set value of last called method to given variable
     *
     * @param mixed &$var variable
     * @return Chainable
     */
    public function __getReturn(&$var)
    {
        $var = array_pop($this->returns);
        return $this;
    }

    /**
     * Reset $returns propery
     *
     * @return Chainable
     */
    public function __resetReturns()
    {
        $this->returns = array();
        return $this;
    }
}
