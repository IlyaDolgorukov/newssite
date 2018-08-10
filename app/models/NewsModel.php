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
}
