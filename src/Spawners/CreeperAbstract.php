<?php
namespace Spawners;

abstract class CreeperAbstract implements CreeperInterface
{
    private $farmer;
    private static $instance;

    private function __construct($caller)
    {
        if ($caller instanceOf Farmer) {
            $this->farmer = $caller;           
        }
    }

    protected static function load($class_name, $caller)
    {
        if (self::$instance) {
            self::$inctance = new $class_name($caller);
        }
        return self::$instance;
    }

    public static function __callStatic($call, $values)
    {
        $self = self::getInstance();
        $self->getFarmerInstance()->__callStatic($call, $values);
    }

    protected function getFarmerInstance()
    {
        return $this->farmer;
    }
}