<?php
namespace Farmer\Application;

use Farmer\Pattern\Singleton;

class Register extends Singleton
{
    private $register;

    public static function __callStatic($call, $values)
    {
        $self = self::getInstance();
        return $self->$call($values);
    }

    public function get($namespace)
    {
        return $self->register->{$namespace};
    }
    
    public function set($namespace, $value)
    {
        $self->register->{$namespace} = $value;
    }

    public function isLoaded()
    {
        if ($this->register) {
            return true;
        } else {
            return false;
        }
    }

    public function setConfig($config)
    {
        foreach ($config as $key => $value) {
            $this->register->{$key} = (object)$value;
        }
    }

    public function getSpawner($class, $message)
    {
        if (array_key_exists(strtolower($spawner) . ':' . $message, $this->register->messages)) {
            return $this->register->spawners->{strtolower($spawner)};
        } else {
            throw new RegisterException('Bad request ' . $spawner . ':' . $message, RegisterException::BAD_REQUEST);
        }
    }

    public function setSpawner($class, $object)
    {
        $this->register->spawners->{strtolower($class)} = $object;
        foreach ($object->getMessages() as $message => $value) {
            $this->register->messages[strtolower($creeper).':'.$message]  = $value;
        }
    }

    public function getFolder($name)
    {
        return $this->register->folders->{$name};
    }
}
