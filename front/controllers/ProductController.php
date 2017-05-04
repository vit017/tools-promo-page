<?php


namespace V_Corp\front\controllers;

use V_Corp\base\controllers\Controller;
use V_Corp\base\exceptions\NotFoundHttpException;
use V_Corp\common\models\ProductModel;
use V_Corp\front\views\ProductView;


class ProductController extends Controller
{


    public static function index()
    {
        $models = ProductModel::findAll();
        $view = new ProductView('index', $models);
        $view->title = 'Products Page';
        $view->model = new ProductModel();
        $view->controller = new self();

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

    public static function add()
    {
        if (is_array($_POST) && count($_POST)) {
            $model = new ProductModel();
            $model->load($_POST);
            $model->save();
            self::redirect('/manager/products');
        }

        $model = new ProductModel();
        $view = new ProductView('update', $model);
        $view->title = 'Create Product';
        $view->model = $model;
        $view->controller = new self();

        $view->render();
    }

    public static function update()
    {
        $id = (int)$_GET['id'];

        if (is_array($_POST) && count($_POST)) {
            $model = ProductModel::find($id);
            $model->load($_POST);
            $model->save();
            self::redirect('/manager/products');
        }

        if ($model = ProductModel::find($id)) {
            $view = new ProductView('update', $model);
            $view->title = 'Update Product#' . $model->id . ' "' . $model->name . '"';
            $view->model = $model;
            $view->controller = new self();

            $view->render();
        } else {
            throw new NotFoundHttpException('Product #' . $id . ' not found');
        }
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

}