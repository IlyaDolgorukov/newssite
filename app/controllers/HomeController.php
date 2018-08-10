<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace app\controllers;

use app\models\NewsModel;
use core\Controller;
use core\Request;

class HomeController extends Controller
{
    protected $limit = 5;

    public function indexAction()
    {
        $model = new NewsModel();
        $page = Request::get('page', 1, 'int');
        $offset = ($page - 1) * $this->limit;
        $title = 'Home Page';
        $this->view->setTitle($title);
        $this->view->setMeta('Keywords', $title);
        $this->view->setMeta('Description', $title);
        $this->view->assign('name', 'testim');
        $this->view->assign('news', $model->getNews($this->limit, $offset));
    }
}
