<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\App;
use V_Corp\base\controllers\Controller;
use V_Corp\common\models\PromoModel;
use V_Corp\manager\Pagination;
use V_Corp\manager\views\PromoView;


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
        $model = ($id > 0) ? PromoModel::find($id) : new PromoModel();
        if (is_array($_POST) && count($_POST)) {
            $model->load($_POST);
            if ($model->save()) {
                self::redirect('/manager/');
            }
        }

        return $model;
    }

    public static function add()
    {
        App::instance()->title('Add Promo');
        self::save();
    }

    public static function update()
    {
        App::instance()->title('Update Promo #'.(int)$_GET['id']);
        self::save((int)$_GET['id']);
    }

    protected static function save($id = 0)
    {
        $model = self::post($id);

        (new PromoView('update', $model))->render();
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

}