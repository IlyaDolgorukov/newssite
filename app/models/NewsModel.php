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
 * Class NewsModel
 * @package app\models
 */
class NewsModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'news';

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getNews($limit = 5, $offset = 0)
    {
        $sql = "
            SELECT * FROM {$this->getTable()}
            ORDER BY date DESC
            LIMIT {$limit} OFFSET {$offset}
        ";
        return $this->query($sql)->fetchAll('id');
    }

    /**
     * @return mixed|null
     */
    public function getNewsCount()
    {
        $sql = "
            SELECT COUNT(*)
            FROM {$this->getTable()}
        ";
        return $this->query($sql)->countAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getNewsById($id)
    {
        $sql = "
            SELECT * FROM {$this->getTable()}
            WHERE id = {$id}
        ";
        return $this->query($sql)->fetchAssoc();
    }

    /**
     * @param $data
     * @return int
     */
    public function addNews($data)
    {
        $columns = array('author', 'title', 'short_text', 'full_text');
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
}
