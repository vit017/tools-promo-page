<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\App;
use V_Corp\common\models\ProductModel;
use V_Corp\manager\views\ProductView;

class ProductController extends ManageController
{

    protected static $flash = [];
    protected static $numPages = 10;
    protected static $indexUrl = '/manager/products';

    protected static $model = ProductModel::class;
    protected static $view = ProductView::class;


    public static function index()
    {
        App::instance()->title('Products');
        parent::index();
    }

    public static function add()
    {
        App::instance()->title('Add Product');
        parent::save();
    }

    public static function update()
    {
        App::instance()->title('Update Product #'.(int)$_GET['id']);
        parent::save((int)$_GET['id']);
    }

    public static function import()
    {
        if (!$_FILES['import']['tmp_name']) {
            self::redirect(self::$indexUrl);
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
                $model = new self::$model();
                $model->load($arData[$k]);
                $models[$k] = $model;
                $k++;
            }
        }
        fclose($handle);

        $insert = call_user_func_array([self::$model, 'insertAll'], [$models]);

        if ($insert['result']) {
            self::flash('import', 'Inserted '.$insert['count'].' rows');
        }
        else {
            self::flash('import', 'Error: '.$insert['message']);
        }

        self::redirect(self::$indexUrl);
    }

}