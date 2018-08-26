<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace core;

/**
 * Class Controller
 * @package core
 */
abstract class Controller
{
    /**
     * @var string
     */
    protected $layout_template = '';
    /**
     * @var string
     */
    protected $view_template = '';
    /**
     * @var
     */
    protected $view;

    /**
     *
     */
    public function before()
    {
        $this->view = new View($this->layout_template, $this->view_template);
    }

    /**
     *
     */
    public function after()
    {
        $this->view->display();
    }
}
