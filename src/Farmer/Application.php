<?php
namespace Farmer;

use Farmer\Application\Register;

class Application
{
    private static $instance;
    private $register = array();

    const NAMESPACE_SEPARATOR = '\\';

    public function __construct($environment = 'production')
    {
        $this->environment = $environment;
        $this->register = Register::getInstance();
        if (!$this->register->isLoaded()) {
            $this->register->setConfig(json_decode(file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config.json')));
        }
    }

    public function registerCoreApplication()
    {

    }

    private static function getInstance()
    {
        if (!self::$instance) {
            try {
                self::$instance = new Application();
                //self::$instance->creepSpawn();
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
        $creeper_namespace = static::NAMESPACE_SEPARATOR . 'Spawners' . static::NAMESPACE_SEPARATOR . $creeper;
        $creep = $creeper_namespace::getInstance($this);
        if ($creep instanceof \Spawners\CreeperAbstract) {
            $register = Register::getInstance();
            $register->setSpawner(strtolower($creeper), $creep);
        } else {
            throw new Application\Exception($creeper_namespace . ' must be a instance of Spawners\CreeperAbstract and Spawners\CreeperInterface', Application\Exception::BAD_IMPLEMENTATION);
        }
    }

    protected function sendTo($spawner, $message, $value)
    {
        $spawner = $this->register->getSpawner(strtolower($spawner), $message)->$message($value);
    }

    private function kill($creeper)
    {
        unset($this->registry->spawners->{$creeper});
    }

    protected function creepSpawn()
    {
        $creepers = scandir(self::SPAWNERS_DIR());
        self::requireOnce('CreeperAbstract.php');
        self::requireOnce('CreeperInterface.php');

        if ($creepers) {
            $ignored_files = (array)$this->register->get('ignored');

            foreach ($creepers as $creeper) {
                if (!in_array($creeper, $ignored_files)) {
                    $this->requireOnce($creeper);
                    $this->pop(substr($creeper, 0, -4));
                }
            }
        } else {
            throw new Application\Exception('Spawner directory not found', Application\Exception::BAD_FOLDER);
        }
    }

    protected function requireOnce($filename)
    {
        try {
            require_once(self::SPAWNERS_DIR() . $filename);
        } catch (\Exception $e) {
            throw new Application\Exception('File not found ' . self::SPAWNERS_DIR() . $filename, Application\Exception::FILE_DO_NOT_EXIST);
        }
    }

    public static function __callStatic($call, $values)
    {
        $self = self::getInstance();
        if ($call === 'set') {
            $self->setInRegister($call, $values);
        } elseif (substr($call, 0, 6) === 'sendTo' && count($values) === 2) {
            return $self->sendTo(substr($call, 6), $values[0], $values[1]);
        } elseif (substr($call, -4, 4) === '_DIR') {
            return $self->getFolder(strtolower(substr($call, 0, -4)));
        } else {
            throw new Application\Exception('Static call inexistant', Application\Exception::BAD_REQUEST);
        }
    }

    protected function getFolder($key)
    {
        $folder = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . $this->register->getFolders($key);
        if (file_exists($folder)) {
            return realpath($folder) . DIRECTORY_SEPARATOR;
        } else {
            throw new Application\Exception('Folder "' . $folder . '" does not exist', Application\Exception::BAD_FOLDER);
        }
    }
}
?>