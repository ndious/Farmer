<?php

require_once __DIR__ . "/../../vendor/autoload.php";

$parserYml = new \Farmer\Libs\Parser\YamlParser();
$parserJson = new \Farmer\Libs\Parser\JsonParser();
$parserXml = new \Farmer\Libs\Parser\XmlParser();

$config = \Farmer\Libs\Config\ConfigFactory::getInstance($parserJson);
$config->load(__DIR__ . "/../../config.json");
print ($config);

?>
