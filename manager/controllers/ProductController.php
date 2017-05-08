<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\App;
use V_Corp\common\models\ProductModel;
use V_Corp\manager\views\ProductView;
use V_Corp\manager\views\ErrorView;

class ProductController extends ManageController
{

    protected static $flash = [];
    protected static $numPages = 10;
    protected static $title = 'Products';
    protected static $indexUrl = '/manager/products';

    protected static $model = ProductModel::class;
    protected static $view = ProductView::class;


    protected static function post($id = 0)
    {
        $numArgs = func_num_args();
        if (!$numArgs) {
            $model = new ProductModel();
        } elseif ($numArgs && $id) {
            $model = ProductModel::find($id);
        }

        if (!$model) {
            return null;
        }

        if (is_array($_POST) && count($_POST)) {
            $model->load($_POST);
            if ($model->save()) {
                self::redirect('/manager/products');
            }
        }

        return $model;
    }

    protected static function save($id = 0)
    {
        $model = func_num_args() ? self::post($id) : self::post();
        if (!$model) {
            $view = new ErrorView('main', 400, 'Bad request');
        } else {
            $view = new ProductView('update', $model);
        }

        $view->render();
    }

    public static function add()
    {
        App::instance()->title('Add Product');
        self::save();
    }

    public static function update()
    {
        App::instance()->title('Update Product #'.(int)$_GET['id']);
        self::save((int)$_GET['id']);
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

        $result = ProductModel::insertAll($models);
        if ($result) {
            self::flash('import', 'Inserted '.$result['count'].' rows');
        }

        self::redirect('/manager/products');
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

}