<?php
namespace Farmer\Application;

use Farmer\Application;

abstract class Exception extends \Exception
{
	const BAD_FOLDER = 1;
	const FILE_DO_NOT_EXIST = 2;

    public function __construct($message, $code, $previous)
    {
        Application::sendToLogger($message);
        parent::__construct($message, $code, $previous);
    }
}
