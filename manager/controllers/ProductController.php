<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\App;
use V_Corp\base\controllers\Controller;
use V_Corp\common\models\ProductModel;
use V_Corp\manager\views\ProductView;
use V_Corp\manager\Pagination;


class ProductController extends Controller
{

    protected static $flash = [];
    protected static $numPages = 10;

    public static function index()
    {
        App::instance()->title('Products');
        $page = ((int)$_GET['page'] > 0) ? ((int)$_GET['page'] - 1) : 0;
        $offset = self::$numPages * $page;
        $models = ProductModel::pageAll($offset, self::$numPages);

        $view = new ProductView('index', $models);
        $view->pagination = new Pagination(ProductModel::count(), self::$numPages, $page);
        $view->controller = self::class;

        $view->render();
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
        App::instance()->title('Add Product');
        self::save();
    }

    public static function update()
    {
        App::instance()->title('Update Product #'.(int)$_GET['id']);
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