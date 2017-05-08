<?php



namespace V_Corp\manager\controllers;

use V_Corp\base\App;
use V_Corp\base\controllers\Controller;
use V_Corp\manager\Pagination;

class ManageController extends Controller {


    public static function index()
    {
        App::instance()->title(static::$title);
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


}