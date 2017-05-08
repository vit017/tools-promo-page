<?php



namespace V_Corp\manager\controllers;

use V_Corp\base\controllers\Controller;
use V_Corp\manager\Pagination;
use V_Corp\manager\views\ErrorView;

class ManageController extends Controller {

    protected static $indexUrl = '/manager/';

    public static function index()
    {
        $page = ((int)$_GET['page'] > 0) ? ((int)$_GET['page'] - 1) : 0;
        $offset = static::$numPages * $page;
        $models = call_user_func_array([static::$model, 'pageAll'], [$offset, static::$numPages]);

        $view = new static::$view('index', $models);
        $view->pagination = new Pagination(call_user_func_array([static::$model, 'count'], [$offset, static::$numPages]), static::$numPages, $page);
        $view->controller = static::class;

        $view->render();
    }

    public static function delete()
    {
        $id = (int)$_GET['id'];

        if ($model = call_user_func_array([static::$model, 'find'], [$id])) {
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
            $model = call_user_func_array([static::$model, 'find'], [$id]);
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