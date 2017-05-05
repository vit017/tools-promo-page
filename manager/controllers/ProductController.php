<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\controllers\Controller;
use V_Corp\base\exceptions\NotFoundHttpException;
use V_Corp\common\models\ProductModel;
use V_Corp\manager\views\ProductView;


class ProductController extends Controller
{

    public static function show($action)
    {
        if (method_exists(static::class, $action)) {
            return call_user_func([static::class, $action]);
        }
    }

    public static function index()
    {
        $models = ProductModel::findAll();
        (new ProductView('index', $models))->render();
    }

    public static function delete()
    {
        $id = (int)$_GET['id'];

        if ($model = ProductModel::find($id)) {
            $model->delete();
        }

        self::redirect('/manager/products');
    }

    protected static function post($id = 0)
    {
        $model = ($id > 0) ? ProductModel::find($id) : new ProductModel();
        if (is_array($_POST) && count($_POST)) {
            $model->load($_POST);
            if ($model->save()) {
                self::redirect('/manager/products');
            }
        }

        return is_object($model) ? $model : new ProductModel();
    }

    public static function add()
    {
        self::save();
    }

    public static function update()
    {
        self::save((int)$_GET['id']);
    }

    protected static function save($id = 0)
    {
        $model = self::post($id);

        (new ProductView('update', $model))->render();
    }

    public static function import()
    {
        if (!$_FILES['import']['tmp_name']) {
            self::redirect('/manager/products');
        }
        $fName = $_FILES['import']['tmp_name'];
        $arTitle = [];
        $arData = [];
        $models = [];
        $handle = fopen($fName, 'r');
        $k = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (!$arTitle) {
                $arTitle = $data;
            } else {
                foreach ($data as $i => $val) {
                    $arData[$k][$arTitle[$i]] = $val;
                }
                $model = new ProductModel();
                $model->load($arData[$k]);
                $models[$k] = $model;
                $k++;
            }
        }
        fclose($handle);

        ProductModel::insertAll($models);

        self::redirect('/manager/products');
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

}