<?php
namespace Farmer\Application;

use Farmer\Application;

class Runtime
{
    private $pile;
    
    public function __construct(array $pile)
    {
        $this->pile = $pile;
        Application::sendToRegister('save', $this);
    }
    
    public function execute()
    {
        Application::sentToDispatcher('event', 'runtime:preexecute');
        foreach ($this->pile as $key => $value) {
            Application::sentToDispatcher('event', '$value:preexecute');
            Application::{'sendTo' . ucfirst($value)}('execute');
            Application::sentToDispatcher('event', 'runtime:postexecute');
        }
        Application::sentToDispatcher('event', 'runtime:preexecute');
    }
}