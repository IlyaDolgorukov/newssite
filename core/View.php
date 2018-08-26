<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace core;

/**
 * Class View
 * @package core
 */
class View
{
    /**
     * @var string
     */
    protected $postfix = '.php';
    /**
     * @var string
     */
    protected $layout_path;
    /**
     * @var string
     */
    protected $view_path;
    /**
     * @var null
     */
    protected $layout = null;
    /**
     * @var null
     */
    protected $view = null;
    /**
     * @var string
     */
    protected $title = '';
    /**
     * @var array
     */
    protected $meta = array();
    /**
     * @var array
     */
    protected $template_data = array();

    /**
     * View constructor.
     * @param string $layout
     * @param string $view
     */
    public function __construct($layout = '', $view = '')
    {
        $controller = Request::param('controller', '', 'string');
        $this->view_path = APP . '/views/' . strtolower($controller) . '/';
        $this->layout_path = APP . '/views/layout/';
        if (empty($layout) && $layout !== null) {
            $this->setLayout('default');
        } else {
            $this->setLayout($layout);
        }
        if (empty($view) && $view !== null) {
            $action = Request::param('action', null, 'string');
            $this->setView($action);
        } else {
            $this->setView($view);
        }
    }

    /**
     * @param null $layout
     */
    public function setLayout($layout = null)
    {
        if (!empty($layout)) {
            $layout = ucfirst(strtolower($layout));
            $file = $this->layout_path . $layout . $this->postfix;
            if (file_exists($file)) {
                $this->layout = $file;
            } else {
                sc()->showError('Шаблон ' . $file . ' не найден');
            }
        } elseif ($layout === null) {
            $this->layout = null;
        }
    }

    /**
     * @param null $view
     */
    public function setView($view = null)
    {
        if (!empty($view)) {
            $view = ucfirst(strtolower($view));
            $file = $this->view_path . $view . $this->postfix;
            if (file_exists($file)) {
                $this->view = $file;
            } else {
                sc()->showError('Вид ' . $file . ' не найден');
            }
        } elseif ($view === null) {
            $this->view = null;
        }
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
    }

    /**
     * @param $name
     * @param $content
     */
    public function setMeta($name, $content)
    {
        if (is_string($name)) {
            $this->meta[$name] = $content;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function assign($name, $value)
    {
        if (is_string($name)) {
            $this->template_data[$name] = $value;
        }
    }

    /**
     *
     */
    public function display()
    {
        if ($this->view !== null) {
            //return HTML
            $title = $this->title;
            $meta = (is_array($this->meta)) ? $this->meta : array();
            if (is_array($this->template_data) && !empty($this->template_data)) {
                extract($this->template_data);
            }
            ob_start();
            require $this->view;
            $content = ob_get_clean();
            if ($this->layout !== null) {
                require $this->layout;
            }
        } else {
            //return JSON
        }
    }
}
