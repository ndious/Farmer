<?php
namespace Farmer\Spawners;

interface CreeperInterface
{
    public function buildRegister();
    public function setScope($key, $value);
    public function getScope($key);
}