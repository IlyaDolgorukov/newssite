<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace app\models;

use core\Model;

/**
 * Class CommentsModel
 * @package app\models
 */
class CommentsModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'comments';
    /**
     * @var
     */
    protected $comments;

    /**
     * @param $data
     * @return int
     */
    public function addComment($data)
    {
        $columns = array('news_id', 'parent', 'depth', 'author', 'text');
        $insert_data = array();
        foreach ($columns as $col) {
            $val = (isset($data[$col])) ? $data[$col] : '';
            $insert_data[] = '\'' . $this->escape($val) . '\'';
        }
        $insert_data = implode(', ', $insert_data);
        $msql_date = date("Y-m-d H:i:s");
        $sql = "
            INSERT INTO {$this->getTable()} VALUES (NULL, '{$msql_date}', {$insert_data})
        ";
        return $this->query($sql)->insertId();
    }

    /**
     * @param $news_id
     * @return array
     */
    public function getNewsComments($news_id)
    {
        $sql = "
            SELECT * FROM {$this->getTable()}
            WHERE news_id = {$news_id}
            ORDER BY date DESC
        ";
        $result = $this->query($sql)->fetchAll();
        if (!empty($result)) {
            $this->comments = $result;
            $result = $this->sortComments($result);
        }
        return $result;
    }

    /**
     * @param $comments
     * @param int $depth
     * @return array
     */
    private function sortComments($comments, $depth = 0)
    {
        $data = array();
        foreach ($comments as $c) {
            if ($c['depth'] == $depth) {
                $data[] = $c;
            }
        }
        if (!empty($data)) {
            foreach ($data as &$d) {
                $childs = array();
                foreach ($this->comments as $cc) {
                    if ($cc['parent'] == $d['id']) {
                        $childs[] = $cc;
                    }
                }
                if (!empty($childs)) {
                    $next = $depth + 1;
                    $d['childs'] = $this->sortComments($childs, $next);
                }
            }
        }
        return $data;
    }
}
