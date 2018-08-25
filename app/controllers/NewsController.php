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

/**
 * Class NewsController
 * @package app\controllers
 */
class NewsController extends Controller
{
    /**
     * @var array
     */
    private $fields = array('author', 'title', 'short_text', 'full_text');

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
            $title = $news['title'];
            $this->view->setTitle($title);
            $this->view->setMeta('Keywords', $title);
            $this->view->setMeta('Description', $title);
            $this->view->assign('news_id', $news_id);
            $this->view->assign('news', $news);
        }
    }

    /**
     *
     */
    public function addAction()
    {
        $errors = $values = array();
        if (Request::getMethod() == 'post') {
            $data = Request::post('form_data', array(), 'array');
            if (!empty($data)) {
                $result = $this->validateForm($data);
                if (empty($result['errors'])) {
                    //save form & redirect to home page
                } else {
                    extract($result);
                }
            } else {
                $errors = $this->fields;
            }
        }
        $title = 'Добавление новости';
        $this->view->setTitle($title);
        $this->view->setMeta('Keywords', $title);
        $this->view->setMeta('Description', $title);
        $this->view->assign('values', $values);
        $this->view->assign('errors', $errors);
    }

    /**
     * @param $data
     * @return array
     */
    public function validateForm($data)
    {
        $errors = $values = array();
        foreach ($this->fields as $field) {
            $val = (isset($data[$field])) ? Request::clearFormField($data[$field]) : '';
            if (!empty($val)) {
                $values[$field] = $val;
            } else {
                $errors[] = $field;
            }
        }
        return compact('values', 'errors');
    }
}
