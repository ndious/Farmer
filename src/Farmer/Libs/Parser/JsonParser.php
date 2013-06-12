<?php

namespace Farmer\Libs\Parser;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JsonParse
 *
 * @author nbremont
 */
class JsonParser implements IParser {
    
    public function dump($content) {
        return json_decode($content);
    }

    public function parse($content) {
        return json_encode($content);
    }    
}
