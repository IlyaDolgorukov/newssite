<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace app\models;

use core\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';
    protected $comments;

    public function getNewsComments($news_id)
    {
        $sql = "
            SELECT * FROM {$this->getTable()}
            WHERE news_id = {$news_id}
        ";
        $result = $this->query($sql)->fetchAll();
        if(!empty($result)){
            $this->comments = $result;
            $result = $this->sortComments($result);
        }
        return $result;
    }

    private function sortComments($comments, $depth = 0){
        $data = array();
        foreach($comments as $c){
            if($c['depth'] == $depth){
                $data[] = $c;
            }
        }
        if(!empty($data)){
            foreach($data as &$d){
                $childs = array();
                foreach($this->comments as $cc){
                    if($cc['parent'] == $d['id']){
                        $childs[] = $cc;
                    }
                }
                if(!empty($childs)){
                    $next = $depth + 1;
                    $d['childs'] = $this->sortComments($childs, $next);
                }
            }
        }

        return $data;
    }
}
