<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\controllers\Controller;
use V_Corp\common\models\PromoModel;
use V_Corp\manager\views\PromoView;


class PromoController extends Controller
{


    public static function index()
    {
        $models = PromoModel::findAll();
        $view = new PromoView('index', $models);
        $view->title = 'Promo Pages';
        $view->model = new PromoModel();
        $view->controller = new self();

        $view->render();
    }

    public static function delete()
    {
        $id = (int)$_GET['id'];

        if ($model = PromoModel::find($id)) {
            $model->delete();
        }

        self::redirect('/manager/');
    }

    public static function update() {
        $id = (int)$_GET['id'];

        if (is_array($_POST) && count($_POST)) {
            $model = PromoModel::find($id);
            $model->load($_POST);
            if ($model->save()) {
                self::redirect('/manager/');
            }
        }

        if ($model = PromoModel::find($id)) {
            $view = new PromoView('update', $model);
            $view->title = 'Update Promo#'.$model->id.' "'.$model->name.'"';
            $view->model = $model;
            $view->controller = new self();

            $view->render();
        }
    }

    public static function redirect($url)
    {
        header('Location: '.$url);
        exit();
    }

}