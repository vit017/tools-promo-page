<?php



namespace V_Corp\common\models;

use V_Corp\base\models\ModelMysqli;


class PromoModel extends ModelMysqli {

    public $id;
    public $url;
    public $name;
    public $date_show_start;
    public $date_show_end;
    public $header;
    public $footer;

    public $products;


    public function __toString()
    {
        return $this->name.' #'.$this->id;
    }

    public function attributes() {
        return [
            'id' => 'Id',
            'url' => 'Page Url',
            'name' => 'Page Title',
            'date_show_start' => 'Page show start',
            'date_show_end' => 'Page show end',
            'header' => 'Header',
            'footer' => 'Footer',
        ];
    }

    public function types() {
        return [
            'id' => 'noedit',
            'url' => 'raw',
            'name' => 'raw',
            'date_show_start' => 'date',
            'date_show_end' => 'date',
            'header' => 'text',
            'footer' => 'text',
        ];
    }

    public function keys() {
        return array_keys($this->attributes());
    }

    public function values() {
        $types = $this->types();
        $res = [];
        foreach ($this->attributes() as $key => $val) {
            $res[] = $this->$key;
        }

        return $res;
    }

    public static function tableName() {
        return 'corp_promo';
    }


    public static function findAll() {
        return parent::findAll();
    }

    public static function find(int $id) {
        return parent::find($id);
    }

    public static function findByAttr($key, $val, $condition) {
        return parent::findByAttr($key, $val, $condition);
    }

    public function afterFind() {
        $types = $this->types();
        foreach ($this->keys() as $i => $key) {
            if (('date' === $types[$key]) && $this->$key) {
                $this->$key = date('d.m.Y H:i', $this->$key);
            }
        }
    }

    public function beforeSave() {
        $types = $this->types();
        foreach ($this->keys() as $i => $key) {
            if (('date' === $types[$key]) && $this->$key) {
                $this->$key = strtotime($this->$key);
            }
        }
    }

    public function load(array $input) {
        foreach ($input as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }





}