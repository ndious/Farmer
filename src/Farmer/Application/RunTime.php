<?php
namespace Farmer\Application;

/**
 * @depend Config
 */
class RunTime implements \Iterator
{
    private $runtime;
    
    public function __construct($config)
    {
        $this->runtime = $config->get('runtime');
    }
    
    public function valid()
    {
        ;
    }
    
    public function key()
    {
        ;
    }
    
    public function current()
    {
        ;
    }
    
    public function rewind()
    {
        ;
    }
    
    public function next()
    {
        ;
    }
}