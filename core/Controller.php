<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace core;

abstract class Controller
{
    protected $layout_template = '';
    protected $view_template = '';
    protected $view;

    public function before()
    {
        $this->view = new View($this->layout_template, $this->view_template);
    }

    public function after()
    {
        $this->view->display();
    }
}
