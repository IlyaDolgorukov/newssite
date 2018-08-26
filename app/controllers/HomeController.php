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
        $news_count = $model->getNewsCount();
        $title = 'Главная страница';
        $this->view->setTitle($title);
        $this->view->setMeta('Keywords', $title);
        $this->view->setMeta('Description', $title);
        $this->view->assign('news', $model->getNews($this->limit, $offset));
        $this->view->assign('news_count', $news_count);
        $this->view->assign('news_page', $page);
        $this->view->assign('news_pages', ceil($news_count / $this->limit));
        $this->view->assign('news_limit', $this->limit);
    }
}
