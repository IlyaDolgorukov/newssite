<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace core;

/**
 * Class Application
 * @package core
 */
final class Application
{
    /**
     * @var
     */
    private static $instance;
    /**
     * @var array|mixed
     */
    private $routes = array();
    /**
     * @var
     */
    private $db_handler;

    /**
     * Application constructor.
     */
    private function __construct()
    {
        $this->routes = require ROOT . '/config/routing.php';
    }

    /**
     * Prevent the instance from being cloned
     */
    private function __clone()
    {

    }

    /**
     * Prevent the instancefrom being unserialized
     */
    private function __wakeup()
    {

    }

    /**
     * @return Application
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param $url
     * @return bool
     */
    private function matchRoute($url)
    {
        foreach ($this->routes as $pattern => $route) {
            $vars = array();
            if (preg_match_all('/<([a-z_]+):?([^>]*)?>/ui', $pattern, $match, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
                $offset = 0;
                foreach ($match as $m) {
                    $vars[] = $m[1][0];
                    if ($m[2][0]) {
                        $p = $m[2][0];
                    } else {
                        $p = '.*?';
                    }
                    $pattern = substr($pattern, 0, $offset + $m[0][1]) . '(' . $p . ')' . substr($pattern, $offset + $m[0][1] + strlen($m[0][0]));
                    $offset = $offset + strlen($p) + 2 - strlen($m[0][0]);
                }
            }
            if (preg_match('!^' . $pattern . '$!ui', $url, $match)) {
                if ($vars) {
                    array_shift($match);
                    if (empty($match[0])) continue;
                    foreach ($vars as $i => $v) {
                        if (isset($match[$i]) && !Request::param($v)) {
                            Request::setParam($v, $match[$i]);
                        }
                    }
                }
                foreach ($route as $k => $v) {
                    Request::setParam($k, $v);
                }
                $action = Request::param('action', '', 'string');
                if (empty($action)) {
                    Request::setParam('action', 'index');
                }
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    private function getQuery()
    {
        $query = rtrim($_SERVER['QUERY_STRING'], '/');
        if (!empty($query)) {
            $params = explode('&', $query, 2);
            if (strpos($params['0'], '=')) {
                $query = '';
            } else {
                $query = rtrim($params[0], '/');
            }
        }
        return $query;
    }

    /**
     * @param $class
     * @param $type
     * @return string
     */
    private function getCamelCaseName($class, $type)
    {
        $type = ucfirst(strtolower($type));
        if ($type == 'Action') {
            $class = strtolower($class);
            $result = $class . $type;
        } else {
            $class = ucfirst(strtolower($class));
            $result = $class . $type;
        }

        return $result;
    }

    /**
     * Dispatch routes
     */
    public function dispatch()
    {
        $url = $this->getQuery();
        if ($this->matchRoute($url)) {
            $controller = Request::param('controller', null, 'string');
            $action = Request::param('action', null, 'string');
            if ($controller !== null) {
                $controller = 'app\controllers\\' . $this->getCamelCaseName($controller, 'controller');
                if (class_exists($controller)) {
                    $cObject = new $controller();
                    if ($action !== null) {
                        $action = $this->getCamelCaseName($action, 'action');
                        if (method_exists($cObject, $action)) {
                            if (method_exists($cObject, 'before')) {
                                $cObject->before();
                            }
                            $cObject->$action();
                            if (method_exists($cObject, 'after')) {
                                $cObject->after();
                            }
                        } else {
                            $this->showError("Метод <b>$action</b> контроллера <b>$controller</b> не найден", 404);
                        }
                    } else {
                        $this->showError("Метод <b>$action</b> контроллера <b>$controller</b> не найден", 404);
                    }
                } else {
                    $this->showError("Класс контроллера <b>$controller</b> не найден", 404);
                }
            } else {
                $this->showError("Класс контроллера <b>$controller</b> не найден", 404);
            }
        }
    }

    /**
     * @param array $data
     * @param string $title
     */
    public function debug($data, $title = '')
    {
        if (!empty($title)) echo $title . ':';
        echo '<pre>' . print_r($data, true) . '</pre>';
    }

    /**
     * @param string $msg
     * @param null $code
     * @param bool $exit
     */
    public function showError($msg, $code = null, $exit = true)
    {
        if ($code !== null) {
            http_response_code($code);
        }
        echo $msg;
        if ($exit) exit;
    }
}
