<?php


namespace Farmer\Libs\Parser;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IParse
 *
 * @author nbremont
 */
interface IParser {
    
    public function parse($content);
    public function dump($content);
}
