<?php
namespace Farmer\Pattern;

use Farmer\Application;

class PublishAndSubscribe
{
	private $register;

	public function __construct(Application $application)
	{
		$this->register = $application->getRegister();
	}

	public function subscribe($serviceName, $object)
	{
		$reflexion = new \ReflexionClass($object);
		foreach ($object as $function) {
			if ($this->isPublic($function)) {
				$this->register->registerMessagesService($serviceName, $function);
			}
		}
	}

	public function publish($serviceName, $message, $values)
	{
		$object = $this->getMessageService($serviceName, $message);
		$object->$message($values);
	}
}