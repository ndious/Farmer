<?php


namespace Farmer\Libs\Install\Script;

use Composer\Script\Event,
    Farmer\Application;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sandbox
 *
 * @author nbremont
 */
class Sandbox {
    
    public static function postInstall(Event $event)
    {
        $composer = $event->getComposer();
        $config = $composer->getConfig();
        file_put_contents(dirname($config->get('vendor-dir')) . DIRECTORY_SEPARATOR . 'test.json', json_encode(new \ArrayIterator(array())));
    }
}
