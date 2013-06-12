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
    
    public function dump($content) {
        return \yaml_emit($content);
    }

    public function parse($content) {
        return \yaml_parse($content);
    }    
}
