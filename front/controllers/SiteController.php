<?php


namespace V_Corp\front\controllers;


use V_Corp\base\App;
use V_Corp\front\Pagination;
use V_Corp\base\controllers\Controller;

class SiteController extends Controller
{

    protected static $pageParam = 'page';
    protected static $indexUrl = '/';

    public static function index()
    {
        App::instance()->title('Promo pages');

        $query['where'] =  ['logic'=>'and', 'condition' => [['date_show_start', time(), '<'], ['date_show_end', time(), '>']]];

        $page = ((int)$_GET[static::$pageParam] > 0) ? ((int)$_GET[static::$pageParam] - 1) : 0;
        $query['offset'] = static::$countPage * $page;
        $query['limit'] = static::$countPage;

        $models = call_user_func_array([static::$model, 'findAll'], [$query]);

        $view = new static::$view('index', $models);
        $view->pagination = new Pagination(call_user_func_array([static::$model, 'count'], [$query]), static::$countPage, $page, static::$pageParam);
        $view->render();
    }


}