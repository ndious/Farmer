<?php
namespace Farmer;

class Application
{
    private static $instance;
    private $register = array();

    const NAMESPACE_SEPARATOR = '\\';

    private function __construct()
    {
        $this->register = (object)$this->register;
        $config = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'config.json'));
        
        foreach ($config as $key => $value) {
            $this->register->{$key} = (object)$value;
        }
    }

    private static function getInstance()
    {
        if (!self::$instance) {
            try {
                self::$instance = new Application();
                self::$instance->creepSpawn();
            } catch (\Exception $exception) {
                echo '<pre>';
                var_dump($exception->getCode(), $exception->getMessage());
                echo '</pre>';
            }
        }
        return self::$instance;
    }

    private function pop($creeper)
    {
        $creeper_namespace = 'Spawners'.self::NAMESPACE_SEPARATOR.$creeper;
        $creep = $creeper_namespace::getInstance($this);
        if ($creep instanceof \Spawners\CreeperAbstract) {
            $this->register->spawners->{strtolower($creeper)} = $creep;
            $messages = $creep->getMessages();
            foreach ($messages as $message => $value) {
                $this->register->messages[strtolower($creeper).':'.$message]  = $value;
            }
        } else {
            throw new \Exception($creeper_namespace . ' must be a instance of Spawners\CreeperAbstract and Spawners\CreeperInterface', 1);
        }
    }

    protected function sendTo($spawner, $message, $value)
    {
        if (array_key_exists(strtolower($spawner) . ':' . $message, $this->register->messages)) {
            $this->register->spawners->{strtolower($spawner)}->$message($value);
        } else {
            throw new \Exception('Bad request ' . $spawner . ':' . $message);
        }
    }

    private function kill($creeper)
    {
        unset($this->registry->spawners->{$creeper});
    }

    protected function creepSpawn()
    {
        $creepers = scandir(self::SPAWNERS_DIR());
        require_once(self::SPAWNERS_DIR() . 'CreeperAbstract.php');
        require_once(self::SPAWNERS_DIR() . 'CreeperInterface.php');

        if ($creepers) {
            $this->register->spawners = new \stdClass();
            $this->register->messages = array();
            $ignored_files = (array)$this->register->ignored;

            foreach ($creepers as $creeper) {
                if (!in_array($creeper, $ignored_files)) {
                    $this->requireOnce($creeper);
                    $this->pop(substr($creeper, 0, -4));
                }
            }
        } else {
            throw new \Exception('Spawner directory not found', 1);
        }
    }

    protected function requireOnce($filename)
    {
        try {
            require_once(self::SPAWNERS_DIR() . $filename);
        } catch (\Exception $e) {
            throw new \Exception('File not found ' . self::SPAWNERS_DIR() . $creeper, 1);
        }
    }

    public function register($throw = true, $prepend = false) {
        spl_autoload_register(array($this, 'autoload'), true, $prepend);
        return $this;
    }

    public static function __callStatic($call, $values)
    {
        $self = self::getInstance();
        if ($call === 'set') {
            $sefl->setInRegister($call, $values);
        } elseif (substr($call, 0, 6) === 'sendTo' && count($values) === 2) {
            return $self->sendTo(substr($call, 6), $values[0], $values[1]);
        } elseif (substr($call, -4, 4) === '_DIR') {
            return $self->getFolder(strtolower(substr($call, 0, -4)));
        } else {
            throw new \Exception('Static call inexistant');
        }
    }

    protected function getFolder($key)
    {
        try {
            $folder = $this->register->folders->{$key};
            //return realpath(__DIR__ . DIRECTORY_SEPARATOR . $folder) . DIRECTORY_SEPARATOR;
            return __DIR__;
        } catch (\Exception $error) {
            throw new \Exception($error->getMessage(), 1);
        }
    }
}
?>