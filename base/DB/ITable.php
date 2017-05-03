<?php



namespace V_Corp\DB;



interface ITable {


    public function create();
    public function read();
    public function update();
    public function delete();

    public function fields();
    public function tableName();




}