<?php

namespace Farmer\Libs\Parser;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XmlParse
 *
 * @author nbremont
 */
class XmlParser implements IParser {

    public function dump($content) {
        // to do implements
        return "";
    }

    public function parse($content) {
        return \simplexml_load_string($content);
    }

}
