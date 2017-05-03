<?php



namespace V_Corp\base\Exception;



class NotFoundHttpException extends \Exception {

    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}

