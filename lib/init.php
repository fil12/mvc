<?php

require_once '../config/config.php';

/**
 * @param $class_name
 * @throws Exception
 */
function __autoload($class_name){
    $lib_path  = ROOT.DS.'lib'.DS.strtolower($class_name).'.class.php';
    $controllers_path  = ROOT.DS.'controllers'.DS.str_replace('controller', '',
            strtolower($class_name)).'Controller.php';
    $model_path = ROOT.DS.'models'.DS.strtolower($class_name).'.php';

    if(file_exists($lib_path)){
        require_once ($lib_path);
        //   var_dump($controllers_path);

    }elseif(file_exists($controllers_path)) {
        require_once($controllers_path);
        // var_dump($controllers_path);
    }elseif(file_exists($model_path)){
        require_once ($controllers_path);
    }else{
        // echo"<pre>";

        throw new Exception('Failed to include class' . $class_name);
    }



}


