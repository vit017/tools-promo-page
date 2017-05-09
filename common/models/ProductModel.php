<?php


namespace V_Corp\common\models;

use V_Corp\base\models\Model;
use V_Corp\base\Filer;


class ProductModel extends Model
{

    public $primaryKey = 'id';

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

    public function rules()
    {
        return [
            //$attr => [required, regexp, error msg]
            'code' => [true, '/^[\w-]+$/', 'Only latin symbols, underscores, digits'],
            'name' => [true, '/^[\wа-яёА-Я ]+$/'],
        ];
    }

    public static function tableName()
    {
        return 'corp_product';
    }

    public function afterFind()
    {
        $types = $this->types();
        foreach ($this->keys() as $i => $key) {
            if (('date' === $types[$key]) && $this->$key) {
                $this->$key = date('d.m.Y H:i', $this->$key);
            }
        }

        $query['where'] = ['logic' => 'and', 'condition' => [['id', $this->page, '=']]];
        $this->page = PromoModel::find($query);
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

}