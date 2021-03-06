<?php


namespace V_Corp\base;


class Html
{


    public static function noedit($label, $data)
    {
        if (!$data) return '';

        return '<label class="control-label">' . $label . '</label>
                <span>' . $data . '</span>';
    }

    public static function raw($label, $name, $data)
    {
        $data = htmlspecialchars($data);
        return '<label class="control-label">' . $label . '</label>
                <input type="text" name="' . $name . '" placeholder="' . $label . '" value="' . $data . '" class="form-control"/>';
    }

    public static function date($label, $name, $data)
    {
        $data = htmlspecialchars($data);
        return '<label class="control-label">' . $label . '</label>
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
        $data = htmlspecialchars($data);
        return '<label class="control-label">' . $label . '</label>
                <textarea name="' . $name . '" class="form-control editor" value="' . $data . '" cols="30" rows="10">' . $data . '</textarea>';
    }

    public static function img($label, $name, $data)
    {
        $out = '<label class="control-label">' . $label . '</label>
                <input type="file" name="' . $name . '">';

        if ($data) {
            $out .= '<img src="' . $data . '">';
        }

        return $out;
    }

    public static function select($label, $name, $data, $selected)
    {
        $sOpt = '';
        foreach ($data as $id => $option) {
            $active = ($id == $selected) ? 'selected' : '';
            $option["label"] = htmlspecialchars($option["label"]);
            $sOpt .= '<option ' . $active . ' value="' . $option["value"] . '">' . $option["label"] . '</option>';
        }

        return '<label class="control-label">' . $label . '</label>
                <select name="' . $name . '" class="form-control">' . $sOpt . '</select>';
    }


}