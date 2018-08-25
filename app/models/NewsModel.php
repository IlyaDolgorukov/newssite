<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace app\models;

use core\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    public function getNews($limit = 5, $offset = 0)
    {
        $sql = "
            SELECT * FROM {$this->getTable()}
            ORDER BY date DESC
            LIMIT {$limit} OFFSET {$offset}
        ";
        return $this->query($sql)->fetchAll('id');
    }

    public function getNewsById($id)
    {
        $sql = "
            SELECT * FROM {$this->getTable()}
            WHERE id = {$id}
        ";
        return $this->query($sql)->fetchAssoc();
    }

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
