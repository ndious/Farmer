<?php
namespace Farmer\Application;

use Farmer\Application;

abstract class Exception extends \Exception
{
	const BAD_FOLDER = 1;
	const FILE_DO_NOT_EXIST = 2;
	const BAD_IMPLEMENTATION = 3;
	const BAD_REQUEST = 4;

    public function __construct($message, $code, $previous = null)
    {
        Application::sendToLogger('log', $message);
        parent::__construct($message, $code, $previous);
    }
}
