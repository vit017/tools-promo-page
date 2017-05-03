<?php



namespace V_Corp\DB;

use V_Corp\DB\Exception\TableException;

class Table implements ITable {


    public function create() {}
    public function read() {}
    public function update() {}
    public function delete() {}

    public function fields() {
        throw new TableException('Fields not defined');
    }
    public function tableName() {
        throw new TableException('Table name not defined');
    }





}