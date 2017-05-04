<?php



namespace V_Corp\base\DB;



interface ITable {


    public function insert();
    public function find(array $input);
    public function change(array $input, $data);
    public function remove(array $input);

    public function fields();
    public function tableName();
    public function getConnection();




}