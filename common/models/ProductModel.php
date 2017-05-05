<?php


namespace V_Corp\common\models;

use V_Corp\base\models\Model;
use V_Corp\base\Filer;


class ProductModel extends Model
{

    public $id;
    public $code;
    public $name;
    public $photo;
    public $price;
    public $currency;
    public $articul;
    public $page;

    protected $_errors = [];

    protected static $pages = null;

    public function attributes()
    {
        return [
            'id' => 'Id',
            'code' => 'Code',
            'page' => 'Promo Page',
            'name' => 'Name',
            'photo' => 'Photo',
            'price' => 'Price',
            'currency' => 'Currency',
            'articul' => 'Article number',
        ];
    }

    public function types()
    {
        return [
            'id' => 'noedit',
            'code' => 'raw',
            'page' => 'page',
            'name' => 'raw',
            'photo' => 'img',
            'price' => 'raw',
            'currency' => 'raw',
            'articul' => 'raw',
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

    public function addError($attr, $msg, $value = '')
    {
        $this->_errors[$attr] = $value ? $msg . ' - ' . $value : $msg;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function rules()
    {
        return [
            //$attr => [required, regexp, error msg]
            'code' => [true, '/^\w+$/', 'Only latin symbols, underscores, digits'],
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
        return 'corp_product';
    }


    public static function findAll()
    {
        return parent::findAll();
    }

    public static function find(int $id)
    {
        return parent::find($id);
    }

    public function afterFind()
    {
        $types = $this->types();
        foreach ($this->keys() as $i => $key) {
            if (('date' === $types[$key]) && $this->$key) {
                $this->$key = date('d.m.Y H:i', $this->$key);
            }
        }

        $this->page = PromoModel::find($this->page);
    }

    public function pages()
    {
        return self::$pages;
    }

    public function beforeSave()
    {
        $types = $this->types();
        foreach ($this->keys() as $i => $key) {
            if (('date' === $types[$key]) && $this->$key) {
                $this->$key = strtotime($this->$key);
            }
        }

        if ($_FILES['photo']['tmp_name']) {
            $this->photo = Filer::upload($this, $_FILES['photo']);
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