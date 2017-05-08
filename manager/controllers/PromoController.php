<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\App;
use V_Corp\base\controllers\Controller;
use V_Corp\common\models\PromoModel;
use V_Corp\manager\Pagination;
use V_Corp\manager\views\PromoView;
use V_Corp\manager\views\ErrorView;


class PromoController extends Controller
{

    protected static $numPages = 10;

    public static function index()
    {
        App::instance()->title('Promo pages');

        $page = ((int)$_GET['page'] > 0) ? ((int)$_GET['page'] - 1) : 0;
        $offset = self::$numPages * $page;
        $models = PromoModel::pageAll($offset, self::$numPages);

        $view = new PromoView('index', $models);
        $view->pagination = new Pagination(PromoModel::count(), self::$numPages, $page);

        $view->render();
    }

    public static function delete()
    {
        if ($model = PromoModel::find((int)$_GET['id'])) {
            $model->delete();
        }

        self::redirect('/manager/');
    }

    protected static function post($id = 0)
    {
        $numArgs = func_num_args();
        if (!$numArgs) {
            $model = new PromoModel();
        } elseif ($numArgs && $id) {
            $model = PromoModel::find($id);
        }

        if (!$model) {
            return null;
        }

        if (is_array($_POST) && count($_POST)) {
            $model->load($_POST);
            if ($model->save()) {
                self::redirect('/manager/');
            }
        }

        return $model;
    }

    protected static function save($id = 0)
    {
        $model = func_num_args() ? self::post($id) : self::post();
        if (!$model) {
            $view = new ErrorView('main', 400, 'Bad request');
        } else {
            $view = new PromoView('update', $model);
        }

        $view->render();
    }

    public static function add()
    {
        App::instance()->title('Add Promo');
        self::save();
    }

    public static function update()
    {
        App::instance()->title('Update Promo #' . (int)$_GET['id']);
        self::save((int)$_GET['id']);
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

}