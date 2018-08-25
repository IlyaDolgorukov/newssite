<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace app\controllers;

use app\models\CommentsModel;
use core\Controller;
use core\Request;

/**
 * Class AjaxController
 * @package app\controllers
 */
class AjaxController extends Controller
{
    /**
     * @var array
     */
    protected $response = array();
    /**
     * @var array
     */
    protected $errors = array();

    /**
     *
     */
    public function before()
    {
        header('Content-Type: application/json');
    }

    /**
     *
     */
    public function after()
    {
        $this->sendResult();
        exit;
    }

    /**
     *
     */
    protected function sendResult()
    {
        if (!$this->errors) {
            $data = array('status' => 'ok', 'data' => $this->response);
        } else {
            $data = array('status' => 'fail', 'errors' => $this->errors);
        }
        echo json_encode($data);
    }

    /**
     *
     */
    public function indexAction()
    {
        $news_id = Request::post('news_id', 0, 'int');
        if ($news_id > 0) {
            $fields = array('author', 'text');
            $data = Request::post();
            $result = Request::validateForm($data, $fields);
            if (empty($result['errors'])) {
                $insert_data = array(
                    'news_id' => $news_id,
                    'parent' => Request::post('parent', 0, 'int'),
                    'depth' => Request::post('depth', 0, 'int'),
                    'author' => $result['values']['author'],
                    'text' => $result['values']['text']
                );
                $model = new CommentsModel();
                $id = $model->addComment($insert_data);
                if ($id > 0) {
                    $comment = $insert_data;
                    $comment['date'] = date("d.m.Y H:i");
                    $comment['id'] = $id;
                    $this->response = $comment;
                } else {
                    $this->errors = array('Не удалось добавить комментарий');
                }
            } else {
                $this->errors = $result['errors'];
            }
        } else {
            $this->errors = array('Входные параметры не корректны', 'И тут еще чего-то');
        }
    }
}
