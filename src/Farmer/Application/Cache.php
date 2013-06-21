<?php
namespace Farmer\Application;

use Farmer\Application;

class Cache
{
	private $cacheFolder;

	public function __construct()
	{
		$this->cacheFolder = Aplication::CACHE_DIR;
	}
}