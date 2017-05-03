<?php


namespace V_Corp\manager\controllers;


use V_Corp\base\Controller;
use V_Corp\base\Exception;
use V_Corp\manager\models\Promo;


class Backend extends Controller
{
    public static $title = '';

    public static function index()
    {
        $model = new Promo();
        $render = new Render();
        $render->data = $model->findAll();
        $render->model = $model;
        $render->view = 'index';
        $render->title = 'Promo pages';

        return $render->out();
    }

    public static function add()
    {
        return Render::out('create');
    }

    public static function update()
    {
        $model = new $_GET['model'];
        $id = (int)$_GET['id'];

        if (is_array($_POST) && count($_POST)) {
            $item = $model->load($_POST);
            $model->beforeSave($item);
            if ($model->change(['where' => 'id ='.$id], $item)) {
                return self::redirect('/manager/');
            }
        }

        $render = new Render();
        $render->data = $model->find(['where' => 'id = '.$id]);
        $render->model = $model;
        $render->view = 'update';
        $render->title = 'Update #'.$id;

        return $render->out();
    }

    public static function delete()
    {
        $model = new $_GET['model'];
        $id = (int)$_GET['id'];
        if ($model->remove(['where' => 'id = ' . $id])) {
            return self::redirect('/manager/');
        }

        throw new NotFoundModelException('Record #' . $id . ' not found');
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }
}


