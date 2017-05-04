<?php

namespace V_Corp\base\DB;

use V_Corp\base\Exception\TableException;

abstract class Table {


    public function select($input) {
        $this->_select = is_array($input) ? $input : func_get_args();
    }

    public function order($input) {
        $this->_select = is_array($input) ? $input : func_get_args();
    }

    public function insert() {}

    public function find(array $input = []) {
        self::getConnection()->setTable($this->tableName());
        return self::getConnection()->read($this, $input);
    }

    public function change(array $input, $data) {
        self::getConnection()->setTable($this->tableName());
        return self::getConnection()->update($this, $input, $data);
    }

    public function remove(array $input) {
        self::getConnection()->setTable($this->tableName());
        return self::getConnection()->delete($this, $input);
    }

    public function getConnection()
    {
        return Mysqli::instance();
    }

    public function fields() {
        throw new TableException('Fields not defined');
    }
    public function tableName() {
        throw new TableException('Table name not defined');
    }





}