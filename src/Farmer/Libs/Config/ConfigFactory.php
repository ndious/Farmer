<?php

namespace Farmer\Libs\Config;

use Farmer\Libs\Parser\IParser;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JsonConfig
 *
 * @author nbremont
 */
class ConfigFactory {

    /**
     *
     * @var ConfigFactory 
     */
    public static $instance = null;

    /**
     *
     * @var Farmer\Libs\Parser\Config
     */
    private $config;

    /**
     * 
     * @param \Farmer\Libs\Parser\IParser $parser
     */
    private function __construct(IParser $parser) {
        $this->config = new Config($parser);
    }

    /**
     * 
     * @return Farmer\Libs\Parser\Config
     */
    private function getConfig() {
        return $this->config;
    }

    /**
     * 
     * @param \Farmer\Libs\Parser\IParser $parser
     * @return \Farmer\Libs\Parser\IParser
     */
    public static function getInstance(IParser $parser) {
        if (NULL === self::$instance)
            self::$instance = new ConfigFactory($parser);;
        return self::$instance->getConfig();
    }

}
