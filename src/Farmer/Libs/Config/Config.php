<?php

namespace Farmer\Libs\Config;

use Farmer\Libs\Config\AbstractConfig,
    Farmer\Libs\Parser\IParser;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author nbremont
 */
class Config extends AbstractConfig {
    
    public function __construct(IParser $parser) {
        parent::__construct($parser);
    }
}
