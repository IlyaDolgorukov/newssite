<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace core;

class View
{
    protected $postfix = '.php';
    protected $layout_path;
    protected $view_path;
    protected $layout = null;
    protected $view = null;
    protected $title = '';
    protected $meta = array();
    protected $template_data = array();

    public function __construct($layout = '', $view = '')
    {
        $controller = Request::param('controller', '', 'string');
        $this->view_path = APP . '/views/' . strtolower($controller) . '/';
        $this->layout_path = APP . '/views/layout/';
        if (empty($layout)) {
            $this->setLayout('default');
        } else {
            $this->setLayout($layout);
        }
        if (empty($view)) {
            $action = Request::param('action', null, 'string');
            $this->setView($action);
        } else {
            $this->setView($view);
        }
    }

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

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
    }

    public function setMeta($name, $content)
    {
        if (is_string($name)) {
            $this->meta[$name] = $content;
        }
    }

    public function assign($name, $value)
    {
        if (is_string($name)) {
            $this->template_data[$name] = $value;
        }
    }

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
