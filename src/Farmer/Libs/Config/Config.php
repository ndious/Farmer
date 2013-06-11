<?php

namespace Farmer\Libs\Script\Config;

use Farmer\Libs\Script\Config\AbstractConfig,
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
