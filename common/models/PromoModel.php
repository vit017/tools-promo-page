<?php


namespace V_Corp\common\models;

use V_Corp\base\models\Model;


class PromoModel extends Model
{

    public $id;
    public $url;
    public $name;
    public $date_show_start;
    public $date_show_end;
    public $header;
    public $footer;

    public $products;

    protected $_errors = [];


    public function __toString()
    {
        return $this->name . ' #' . $this->id;
    }

    public function addError($attr, $msg, $value = '')
    {
        $this->_errors[$attr] = $value ? $msg . ' - ' . $value : $msg;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function attributes()
    {
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

    public function types()
    {
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

    public function keys()
    {
        return array_keys($this->attributes());
    }

    public function values()
    {
        $res = [];
        foreach ($this->attributes() as $key => $val) {
            $res[] = $this->$key;
        }

        return $res;
    }

    public function rules()
    {
        return [
            //$attr => [required, regexp, error msg]
            'url' => [true, '/^\w+$/', 'Only latin symbols, underscores, digits'],
            'name' => [true, '/^[\wа-яёА-Я ]+$/'],
        ];
    }

    public function validate()
    {
        $rules = $this->rules();
        foreach ($rules as $attr => $rule) {
            if ($rule[0] && ('' === trim($this->$attr))) {
                $this->addError($attr, $attr . ' is required');
            } elseif ($rule[1] && !preg_match($rule[1], $this->$attr)) {
                $msg = $rule[2] ?: 'wrong value of field ' . $attr;
                $this->addError($attr, $msg);
            }
        }

        return !count($this->_errors);
    }

    public static function tableName()
    {
        return 'corp_page';
    }


    public static function findAll()
    {
        return parent::findAll();
    }

    public static function find(int $id)
    {
        return parent::find($id);
    }

    public static function findByAttr($key, $val, $condition)
    {
        return parent::findByAttr($key, $val, $condition);
    }

    public function afterFind()
    {
        $types = $this->types();
        foreach ($this->keys() as $i => $key) {
            if (('date' === $types[$key]) && $this->$key) {
                $this->$key = date('d.m.Y H:i', $this->$key);
            }
        }
    }

    public function beforeSave()
    {
        $types = $this->types();
        foreach ($this->keys() as $i => $key) {
            if (('date' === $types[$key]) && $this->$key) {
                $this->$key = strtotime($this->$key);
            }
        }
    }

    public function load(array $input)
    {
        foreach ($input as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }


}