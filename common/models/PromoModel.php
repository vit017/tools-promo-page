<?php


namespace V_Corp\common\models;

use V_Corp\base\models\Model;


class PromoModel extends Model
{

    public $primaryKey = 'id';

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

    public static function attributes()
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

    public static function types()
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

    public static function rules()
    {
        return [
            //$attr => [required, regexp, error msg]
            'url' => [true, '/^[\w-]+$/', 'Only latin symbols, underscores, digits'],
            'name' => [true, '/^[\wа-яёА-Я ]+$/u'],
            'date_show_start' => [true],
            'date_show_end' => [true],
        ];
    }

    public static function tableName()
    {
        return 'corp_page';
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

}