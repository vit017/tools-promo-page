<?php


namespace V_Corp\base;

class Html
{


    public static function noedit($label, $name, $data)
    {
        return '<label>' . $label . '</label>
                <span>' . $data . '</span>';
    }

    public static function raw($label, $name, $data)
    {
        return '<label>' . $label . '</label>
                <input type="text" name="' . $name . '" placeholder="' . $label . '" value="' . $data . '" class="form-control"/>';
    }

    public static function date($label, $name, $data)
    {
        return '<label>' . $label . '</label>
                <div class="input-group date datetimepicker">
                    <input type="text" value="' . $data . '" name="' . $name . '" placeholder="' . $label . '"
                           class="form-control"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                ';
    }

    public static function text($label, $name, $data)
    {
        return '<label>' . $label . '</label>
                <textarea name="' . $name . '" class="form-control editor" value="' . $data . '" id="" cols="30" rows="10">'.$data.'</textarea>';
    }


}