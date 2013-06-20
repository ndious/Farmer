<?php
namespace Farmer\Pattern;

use Farmer\Application\Exception;

class PatternException extends Exception
{
    const BAD_IMPLEMENTATION = 1001;
}