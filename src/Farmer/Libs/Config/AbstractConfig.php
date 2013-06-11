<?php

namespace Farmer\Libs\Script\Config;

use Farmer\Libs\Parser\IParser;

/**
 * 
 */
abstract class AbstractConfig implements IConfig {
    
    
    protected $parser;
    /**
     *
     * @var array 
     */
    protected $parameters = array();
    
    /**
     * 
     * @param \Farmer\Libs\Parser\IParser $parser
     */
    public function __construct(IParser $parser) {
        $this->parser = $parser;
    }
    
    /**
     * 
     * @param string $key
     * @param mixte $value
     */
    public function addParameter($key, $value) {
        $this->parameters[$key] = $value;
    }

    /**
     * 
     * @param string $key
     * @return null or mixte
     */
    public function getParameter($key) {
        if (array_key_exists($key, $this->parameters))
            return $this->parameters[$key];
        return null;
    }
    
    /**
     * 
     * @param string $filename
     */
    public function load($filename)
    {
        $content = file_get_contents($filename);
        $this->parameters = $this->parser->parse($content);
    }

    /**
     * 
     */
    public function __toString() {
        
    }

}
