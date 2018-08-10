<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace core;

/**
 * Class Model
 * @package core
 */
abstract class Model
{
    const RESULT_ASSOC = MYSQL_ASSOC;
    const RESULT_NUM = MYSQL_NUM;
    const RESULT_BOTH = MYSQL_BOTH;

    /**
     * @var resource
     */
    protected $handler;
    /**
     * @var
     */
    protected $table;
    /**
     * @var
     */
    protected $result;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->handler = sc()->getDbHandler();
    }

    /**
     * @param $query
     * @return $this
     */
    public function query($query)
    {
        $r = mysql_query($query, $this->handler);
        if (!$r && mysql_errno($this->handler) == 2006 && mysql_ping($this->handler)) { //check error MySQL server has gone away
            $r = mysql_query($query, $this->handler);
        } elseif (!$r && mysql_errno($this->handler) == 1104) { //try set sql_big_selects
            mysql_query('SET SQL_BIG_SELECTS=1', $this->handler);
            $r = mysql_query($query, $this->handler);
        }
        $this->result = $r;
        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->escapeStr($this->table);
    }

    /**
     * @return array
     */
    public function fetchArray()
    {
        return ($this->result) ? mysql_fetch_array($this->result, self::RESULT_NUM) : array();
    }

    /**
     * @return array
     */
    public function fetchAssoc()
    {
        return ($this->result) ? mysql_fetch_assoc($this->result) : array();
    }

    /**
     * @param null $field
     * @param bool $assoc
     * @return array
     */
    public function fetchAll($field = null, $assoc = true)
    {
        $result = array();
        if ($this->result) {
            if ($field !== null) $field = (string)$field;
            if ($assoc) {
                while ($row = $this->fetchAssoc($this->result)) {
                    if ($field !== null && isset($row[$field])) {
                        $result[$row[$field]] = $row;
                    } else {
                        $result[] = $row;
                    }
                }
            } else {
                while ($row = $this->fetchArray($this->result)) {
                    $result[] = $row;
                }
            }
        }
        return $result;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function countAll($key = 'COUNT(*)')
    {
        $result = $this->result ? $this->fetchAssoc($this->result) : array();
        return isset($result[$key]) ? $result[$key] : null;
    }

    /**
     * @return int
     */
    public function insertId()
    {
        return mysql_insert_id($this->handler);
    }

    /**
     * @return int
     */
    public function affectedRows()
    {
        return mysql_affected_rows($this->handler);
    }

    /**
     * @param $string
     * @return string
     */
    public function escape($string)
    {
        return mysql_real_escape_string($string, $this->handler);
    }

    /**
     * @param $string
     * @return string
     */
    public function escapeStr($string)
    {
        return "`" . $string . "`";
    }
}
