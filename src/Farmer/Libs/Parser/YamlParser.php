<?php

namespace Farmer\Libs\Parser;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YamlParser
 *
 * @author nbremont
 */
class YamlParser implements IParser {
    
    public function dump() {
        
    }

    public function parse() {
        return yaml_parse("");
    }    
}
