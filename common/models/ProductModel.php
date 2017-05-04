<?php



namespace V_Corp\common\models;

use V_Corp\base\models\ModelMysqli;


class ProductModel extends ModelMysqli {

    public $id;
    public $code;
    public $name;
    public $photo;
    public $articul;


    public function attributes() {
        return [
            'id' => 'Id',
            'code' => 'Code',
            'page' => 'Promo Page Id',
            'name' => 'Name',
            'photo' => 'Photo',
            'articul' => 'Article number',
        ];
    }

    public function types() {
        return [
            'id' => 'noedit',
            'code' => 'raw',
            'page' => 'select',
            'name' => 'raw',
            'photo' => 'file',
            'articul' => 'raw',
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
        return 'corp_product';
    }


    public static function findAll() {
        return parent::findAll();
    }

    public static function find(int $id) {
        return parent::find($id);
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