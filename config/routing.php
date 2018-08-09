<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

return array(
    'news/<news_id:\d+>' => array(
        'controller' => 'news',
        'action' => 'index'
    ),
    '<controller>/<action>' => array(),
    '<controller>' => array(),
    '' => array(
        'controller' => 'home',
        'action' => 'index'
    ),
);
