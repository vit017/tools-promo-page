<?php


namespace V_Corp\front\controllers;

use V_Corp\base\controllers\Controller;
use V_Corp\base\exceptions\NotFoundHttpException;
use V_Corp\common\models\PromoModel;
use V_Corp\common\models\ProductModel;
use V_Corp\front\views\PromoView;


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

    public static function show($url)
    {

        $model = PromoModel::findByAttr('url', $url, '=');
        $model->products = ProductModel::findAllByAttr('page', $model->id, '=');
        $view = new PromoView('show', $model);
        $view->title = $model->name;
        $view->model = $model;
        $view->controller = new self();

        $view->render();
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

}