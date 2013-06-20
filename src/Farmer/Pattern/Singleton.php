<?php
namespace Farmer\Pattern;

abstract class Singleton
{
    private $instance;
    protected $classNamespace;
    
    protected function __construct()
    {}
    
    public final static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = self::getObject();
        }
        return self::$instance;
    }
    
    protected final static function getObject()
    {
        if ($this->classNamespace) {
            $class = $this->classNamespace;
            return new $class();
        } else {
            throw new PatternExecption('classNamespace was not informed', PatternExecption::BAD_IMPLEMENTATION);
        }
    }
}
