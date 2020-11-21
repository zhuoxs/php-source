<?php

/**
 * model基础类
 * Created by PhpStorm.
 * User: lirui
 * Date: 2017/12/15
 * Time: 1:36
 */
class BaseModel
{
    protected $table;

    public function update($where, $data) {
        $ret = pdo_update($this->table, $data, $where);
        if ($ret) {
            return $ret;
        } else {
            return false;
        }
    }
    public function count($where) {
        return pdo_count($this->table,$where);
    }

    public function getOne($where,$field = '*') {
        $ret = pdo_get($this->table, $where, $field);
        if (!empty($ret)) {
            return $ret;
        } else {
            return array();
        }
    }

    public function getList($where, $field, $order = [], $limit = []) {
        return pdo_getall( $this->table,$where,$field,'',$order,$limit);
    }

    public function add($data) {
        $ret   = pdo_insert($this->table, $data);
        if (!empty($ret)) {
            return pdo_insertid();
        }
        return false;
    }

    public function del($where) {
        $ret   = pdo_delete($this->table, $where);
        if (!empty($ret)) {
            return true;
        }
        return false;
    }

    public function begin() {
        pdo_begin();
    }

    public function commit() {
        pdo_commit();
    }
    public function rollback() {
        pdo_rollback();
    }

    public function getTable() {
        return $this->table;
    }

    public function query($sql) {
        return pdo_query($sql);
    }

    public function pdo_fetch($sql) {
        return pdo_fetch($sql);
    }
}