<?php
namespace Spawners;

class Router extends CreeperAbstract implements CreeperInterface
{
    public function buildRegister()
    {

    }

    public function setScope($key, $value)
    {

    } 

    public function getScope($key)
    {
    	
    }

    public function getMessages()
    {
        return array('update' => 'string');
    }

    public function update($value)
    {
        var_dump('i am updated with '.$value);
    }

    public static function getInstance($caller)
    {
        return parent::load('Router', $caller);
    }
}