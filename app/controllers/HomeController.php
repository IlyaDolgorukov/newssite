<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace app\controllers;

use core\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $title = 'Home Page';
        $this->view->setTitle($title);
        $this->view->setMeta('Keywords', $title);
        $this->view->setMeta('Description', $title);
        $this->view->assign('name', 'testim');
    }
}
