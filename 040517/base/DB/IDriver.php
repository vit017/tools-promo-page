<?php



namespace V_Corp\base\DB;



interface IDriver {



    function create(array $input);
    function read(Table $model, array $input);
    function update(Table $model, array $input, $data);
    function delete(Table $model, array $input);



}