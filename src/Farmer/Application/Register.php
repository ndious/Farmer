<?php
namespace Farmer\Application;

use Farmer\Pattern\Singleton;

class Register extends Singleton
{
    private $register;

    public static function get($namespace)
    {
        $self = self::getInstance();
        return $self->register->{$namespace};
    }
    
    public static function set($namespace, $value)
    {
        $self = self::getInstance();
        $self->register->{$namespace} = $value;
    }
}
