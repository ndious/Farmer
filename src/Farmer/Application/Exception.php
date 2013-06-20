<?php
namespace Farmer\Application;

use Farmer\Application;

abstract class Exception extends \Exception
{
    public function __construct($message, $code, $previous)
    {
        Application::sendToLogger($message);
        parent::__construct($message, $code, $previous);
    }
}
