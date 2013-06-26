<?php
namespace Farmer\Pattern;

use Farmer\Pattern\PatternExecption;

abstract class Singleton
{
    protected static $instance;
    protected static $classNamespace;
    
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
        if (self::$classNamespace) {
            $class = self::$classNamespace;
            return new $class();
        } else {
            throw new PatternException('classNamespace was not informed', PatternException::BAD_IMPLEMENTATION);
        }
    }
}
