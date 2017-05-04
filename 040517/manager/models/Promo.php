<?php


namespace V_Corp\manager\models;

use V_Corp\base\DB\Table;
use V_Corp\base\DB\ITable;


class Promo extends Table implements ITable
{

    public function tableName()
    {
        return 'corp_promo';
    }

    public function fields()
    {
        return [
            'id' => 'Id',
            'name' => 'Name',
            'created' => 'Created At',
            'updated' => 'Updated At',
            'url' => 'Page url',
            'date_show_start' => 'Page start date',
            'date_show_end' => 'Page end date',
            'header' => 'Header',
            'footer' => 'Footer'
        ];
    }

    public function types() {
        return [
            'id' => 'noedit',
            'name' => 'raw',
            'created' => 'noedit',
            'updated' => 'noedit',
            'url' => 'raw',
            'date_show_start' => 'date',
            'date_show_end' => 'date',
            'header' => 'text',
            'footer' => 'text'
        ];
    }

    public function findAll(array $input = [])
    {
        return $this->find($input);
    }

    public function beforeSave() {
        
    }

    public function load(array $input) {
        $fields = $this->fields();
        $item = new \StdClass();
        foreach ($input as $key => $value) {
            if (array_key_exists($key, $fields)) {
                $item->$key = $value;
            }
        }

        return $item;
    }
}