<?php

namespace Farmer\Libs\Config;

/**
 * 
 */
interface IConfig
{
  public function addParameter($key, $value);
  public function getParameter($key);
  public function load($filename);
  public function __toString();
}