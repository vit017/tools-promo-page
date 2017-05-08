<?php



namespace V_Corp\manager\controllers;

use V_Corp\base\controllers\Controller;
use V_Corp\manager\Pagination;
use V_Corp\manager\views\ErrorView;

class ManageController extends Controller {

    protected static $indexUrl = '/manager/';
    protected static $pageParam = 'page';
    protected static $countPage = 10;

    public static function index()
    {
        $page = ((int)$_GET[static::$pageParam] > 0) ? ((int)$_GET[static::$pageParam] - 1) : 0;
        $query['offset'] = static::$countPage * $page;
        $query['limit'] = static::$countPage;

        $models = call_user_func_array([static::$model, 'findAll'], [$query]);

        $view = new static::$view('index', $models);
        $view->pagination = new Pagination(call_user_func_array([static::$model, 'count'], [$query]), static::$countPage, $page, static::$pageParam);
        $view->controller = self::class;
        $view->render();
    }

    public static function delete()
    {
        $id = (int)$_GET['id'];

        $query['where'] = ['logic' => 'AND', 'condition' => [['id', $id, '=']]];
        if ($model = call_user_func_array([static::$model, 'find'], [$query])) {
            $model->delete();
        }

        static::redirect(static::$indexUrl);
    }

    protected static function save($id = 0)
    {
        $model = func_num_args() ? static::post($id) : static::post();
        if (!$model) {
            $view = new ErrorView('main', 400, 'Bad request');
        } else {
            $view = new static::$view('update', $model);
        }

        $view->render();
    }

    protected static function post($id = 0)
    {
        $numArgs = func_num_args();
        $model = null;

        if (!$numArgs) {
            $model = new static::$model();
        } elseif ($numArgs && $id) {
            $query['where'] = ['logic' => 'AND', 'condition' => [['id', $id, '=']]];
            $model = call_user_func_array([static::$model, 'find'], [$query]);
        }

        if (!$model) {
            return null;
        }

        if (is_array($_POST) && count($_POST)) {
            $model->load($_POST);
            if ($model->save()) {
                self::redirect(static::$indexUrl);
            }
        }

        return $model;
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

}