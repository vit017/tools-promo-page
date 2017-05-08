<?php


namespace V_Corp\front\controllers;

use V_Corp\base\App;
use V_Corp\base\controllers\Controller;
use V_Corp\front\controllers\SiteController;
use V_Corp\front\views\ErrorView;
use V_Corp\common\models\PromoModel;
use V_Corp\common\models\ProductModel;
use V_Corp\front\Pagination;
use V_Corp\front\views\PromoView;


class PromoController extends SiteController
{

    protected static $flash = [];
    protected static $countPage = 10;

    protected static $model = PromoModel::class;
    protected static $view = PromoView::class;

    public static function show($url)
    {
        $now = time();
        $query['where'] =  ['logic'=>'and', 'condition' => [['url', $url, '='], ['date_show_start', $now, '<'], ['date_show_end', $now, '>']]];
        $model = call_user_func_array([self::$model, 'find'], [$query]);
        if ($model) {
            $query = ['where' => ['logic' => 'AND', 'condition' => ['page', $model->id, '=']]];
            $model->products = ProductModel::findAll($query);
            $view = new PromoView('show', $model);
            App::instance()->title($model->name);
        }
        else {
            $view = new ErrorView('main', 400, 'Bad request');
        }

        $view->render();
    }
}