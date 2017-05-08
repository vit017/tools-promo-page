<?php


namespace V_Corp\front\controllers;

use V_Corp\base\App;
use V_Corp\base\controllers\Controller;
use V_Corp\front\views\ErrorView;
use V_Corp\common\models\PromoModel;
use V_Corp\common\models\ProductModel;
use V_Corp\front\Pagination;
use V_Corp\front\views\PromoView;


class PromoController extends Controller
{

    protected static $numPages = 10;

    public static function index()
    {
        App::instance()->title('Promo pages');

        $page = ((int)$_GET['page'] > 0) ? ((int)$_GET['page'] - 1) : 0;
        $offset = self::$numPages * $page;
        $models = PromoModel::pageAllByAndCondition($offset, self::$numPages, ['date_show_start', time(), '<'], ['date_show_end', time(), '>']);

        $view = new PromoView('index', $models);
        $view->pagination = new Pagination(PromoModel::count(), self::$numPages, $page);

        $view->render();
    }

    public static function show($url)
    {
        $model = PromoModel::findByAndCondition(['url', $url, '='], ['date_show_start', time(), '<'], ['date_show_end', time(), '>']);
        if ($model) {
            $model->products = ProductModel::findAllByAttr('page', $model->id, '=');
            $view = new PromoView('show', $model);
            App::instance()->title($model->name);
        }
        else {
            $view = new ErrorView('main', 400, 'Bad request');
        }

        $view->render();
    }
}