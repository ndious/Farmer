<?php
namespace Farmer\Application;


class Register
{
    private $register;
    protected static $classNamespace = '\Farmer\Application\Register';

    public function __construct()
    {

    }

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

    private function initRegister()
    {
        if (!$this->isLoaded()) {
            $this->register = new \stdClass();
            $this->register->mapping = new \stdClass();
        }
    }

    public function setConfig($config)
    {
        $this->initRegister();
        foreach ($config as $key => $value) {
            $this->register->{$key} = $value;
            $this->register->mapping->{$key} = $this->getType($value);
        }
        var_dump($this->register);
    }

    public function getType($value)
    {
        if (is_object($value)) {
            return get_class($value);
        } else {
            return gettype($value);
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
