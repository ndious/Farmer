<?php
namespace Farmer\Libs;

use Farmer\Spawners\Router as Spawn;

class Router
{
    private $get;
    private $post;
    private $app;
    private $controller;
    private $action;
    private $routing;
    private $request_uri;
    private static $instance;

    static public function getInstance()
    {
        if (!self::$instance) {
            if (
                Spawn::getEnvironment() == 'development' ||
                !file_exists(Spawn::getCacheDir() . DIRECTORY_SEPARATOR . 'routing.xml')
            ){
                self::compile();
            }

            self::$instance = new router();
        }
        return self::$instance;
    }

    public function getApp()
    {
        return $this->app;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    private function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        if (substr($_SERVER['REQUEST_URI'], -1, 1) == '/') {
            $this->request_uri = substr($_SERVER['REQUEST_URI'], 0, -1);
        } else {
            $this->request_uri = $_SERVER['REQUEST_URI'];
        }
        $this->loadRouting();
        $this->matchRoute();
    }

    private function loadRouting()
    {
        $routing = new \SimpleXmlIterator(farmer::getCacheDir() . DIRECTORY_SEPARATOR . 'routing.xml', null, true);
        $conf = array();
        foreach ($routing as $app) {
            $app_key = $app->getName();

            foreach ($app as $controller) {
                $controller_key = $controller->getName();

                foreach ($controller as $action) {
                    $action_key = $action->getName();
                    $params_values = array();
                    $params = array();
                    $i = 0;

                    foreach ($action->params as $values) {

                        foreach ($values as $value) {
                            $params_values[$value->getName()] = (string)$value;
                            $params[++$i] = $value->getName();
                        }
                    }
                    $conf[$app_key . '|' . $controller_key . '|' . $action_key] = array(
                        'route' => $this->buildPreg((string)$action->route, $params_values),
                        'params' => $params
                    );
                }
            }
        }
        $this->routing = $conf;
    }

    private function buildPreg($string, $params)
    {
        $result = array();
        $find = preg_match_all('/\/:(\w+)/', $string, $result);
        if ($find != 0) {
            foreach ($result[1] as $match) {
                $string = str_replace(':' . $match, $this->getPreg($params[$match]), $string);
            }
        }
        return addcslashes($string, '/');
    }

    private function getPreg($match)
    {
        if ($match == 'string') {
            return '(\w+)';
        } elseif ($match == 'int') {
            return '(\d+)';
        }
    }

    private function matchRoute()
    {
        $match = array();
        foreach ($this->routing as $key => $value) {
            if (preg_match('/^' . $value['route'] . '$/', $this->request_uri, $match)) {
                $key_exploded = explode('|', $key);
                $this->app = $key_exploded[0];
                $this->controller = $key_exploded[1];
                $this->action = $key_exploded[2];

                foreach($value['params'] as $param_key => $param_value){
                    $this->get[$param_value] = $match[$param_key];
                }
            }
        }
    }

    public function getParam($type = false)
    {
        if (!$type && ($type == "post" || $type == "get")) {
            return $this->$type;
        } elseif (array_key_exists($type, $this->get)) {
            return $this->get[$type];
        } elseif (array_key_exists($type, $this->post)) {
            return $this->post[$type];
        } else {
            $value = array(
                'post' => $this->post,
                'get' => $this->get
            );
            return $value;
        }
    }

    static public function compile()
    {
        $app_dir = opendir(farmer::getAppDir());

        $routing_file = fopen(farmer::getCacheDir() . 'routing.xml', 'w');
        fwrite($routing_file, '');
        fclose($routing_file);

        $dom = new \DOMDocument('1.0');
        $dom->encoding = "UTF-8";
        $routing = $dom->createElement('routing');
        $routing_node = $dom->appendChild($routing);


        while(false !== ($dir = readdir($app_dir))){
            if(
                $dir == '.' ||
                $dir == '..' ||
                !is_dir(farmer::getAppDir() . $dir) ||
                !file_exists(farmer::getAppDir() . $dir . DIRECTORY_SEPARATOR . 'routing.xml')
            ) {
                continue;
            }

            $app_routing = simplexml_load_file(farmer::getAppDir() . $dir . DIRECTORY_SEPARATOR . 'routing.xml');

            $app = $dom->createElement($dir);
            $app_node = $routing_node->appendChild($app);
            foreach ($app_routing->children() as $controller) {
                $elem = $dom->createElement($controller->getName());
                $controller_node = $app_node->appendChild($elem);

                foreach ($controller->children() as $action) {
                    $elem = $dom->createElement($action->getName());
                    $action_node = $controller_node->appendChild($elem);

                    foreach ($action->children() as $element) {
                        $elem = $dom->createElement($element->getName());
                        $elem_node = $action_node->appendChild($elem);

                        if ($element->getName() == 'route') {
                            $route = $dom->createTextNode($element);
                            $elem_node->appendChild($route);
                        } else {

                            foreach ($element->children() as $param) {
                                $elem = $dom->createElement($param->getName());
                                $param_node = $elem_node->appendChild($elem);
                                $param_txt = $dom->createTextNode($param);
                                $param_node->appendChild($param_txt);
                            }
                        }
                    }
                }
            }
        }

        closedir($app_dir);
        $dom->save(farmer::getCacheDir() . DIRECTORY_SEPARATOR . 'routing.xml');
    }
}