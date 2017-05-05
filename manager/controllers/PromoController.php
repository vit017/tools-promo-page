<?php


namespace V_Corp\manager\controllers;

use V_Corp\base\controllers\Controller;
use V_Corp\base\exceptions\NotFoundHttpException;
use V_Corp\common\models\PromoModel;
use V_Corp\manager\views\PromoView;


class PromoController extends Controller
{


    public static function show($action)
    {
        if (method_exists(static::class, $action)) {
            return call_user_func([static::class, $action]);
        }
    }

    public static function index()
    {
        $models = PromoModel::findAll();

        (new PromoView('index', $models))->render();
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
        self::save();
    }

    public static function update()
    {
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