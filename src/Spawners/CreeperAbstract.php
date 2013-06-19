<?php
namespace Spawners;

Use Farmer\Application;

abstract class CreeperAbstract implements CreeperInterface
{
    private $application;
    private static $instance;
    const CLASS_NAMESPACE = '\Spawners\\';

    protected function __construct($caller)
    {
        if ($caller instanceOf Application) {
            $this->application = $caller;           
        }
    }

    protected static function load($class_name, $caller)
    {
        if (!self::$instance) {
            $class_name = static::CLASS_NAMESPACE . $class_name;
            self::$instance = new $class_name($caller);
        }
        return self::$instance;
    }

    public static function __callStatic($call, $values)
    {
        $self = self::getInstance();
        $self->getApplication()->__callStatic($call, $values);
    }

    protected function getApplication()
    {
        return $this->application;
    }
}