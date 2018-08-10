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

class NewsController extends Controller
{
    public function indexAction()
    {
        $model = new NewsModel();
        $news_id = Request::param('news_id', 0, 'int');
        if($news_id > 0){
            $news = $model->getNewsById($news_id);
        }else{
            //get last news
            $news = $model->getNews(1);
        }
        if(empty($news)){
            sc()->showError("Новость #{$news_id} не найдена");
        }else{
            $title = 'News Page';
            $this->view->setTitle($title);
            $this->view->setMeta('Keywords', $title);
            $this->view->setMeta('Description', $title);
            $this->view->assign('news_id', $news_id);
            $this->view->assign('news', $news);
        }
    }
}
