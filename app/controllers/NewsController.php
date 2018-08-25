<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace app\controllers;

use app\models\CommentsModel;
use app\models\NewsModel;
use core\Controller;
use core\Request;

/**
 * Class NewsController
 * @package app\controllers
 */
class NewsController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {
        $model = new NewsModel();
        $news_id = Request::param('news_id', 0, 'int');
        if ($news_id > 0) {
            $news = $model->getNewsById($news_id);
        } else {
            //get last news
            $news = $model->getNews(1);
        }
        if (empty($news)) {
            sc()->showError("Новость #{$news_id} не найдена");
        } else {
            $comments_model = new CommentsModel();
            $title = $news['title'];
            $this->view->setTitle($title);
            $this->view->setMeta('Keywords', $title);
            $this->view->setMeta('Description', $title);
            $this->view->assign('news', $news);
            $this->view->assign('comments', $comments_model->getNewsComments($news['id']));
        }
    }

    /**
     *
     */
    public function addAction()
    {
        $errors = $values = array();
        $fields = array('author', 'title', 'short_text', 'full_text');
        if (Request::getMethod() == 'post') {
            $data = Request::post('form_data', array(), 'array');
            if (!empty($data)) {
                $result = Request::validateForm($data, $fields);
                if (empty($result['errors'])) {
                    //save form & redirect to home page
                    $model = new NewsModel();
                    $id = $model->addNews($result['values']);
                    if($id > 0){
                        header('Location: /');
                        exit;
                    }else{
                        sc()->showError("Не удалось добавить новость");
                    }
                } else {
                    extract($result);
                }
            } else {
                $errors = $fields;
            }
        }
        $title = 'Добавление новости';
        $this->view->setTitle($title);
        $this->view->setMeta('Keywords', $title);
        $this->view->setMeta('Description', $title);
        $this->view->assign('values', $values);
        $this->view->assign('errors', $errors);
    }
}
