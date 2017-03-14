<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.03.2017
 * Time: 13:28
 */
class App
{
    protected static $router;

    public static $db;

    /**
     * @return mixed
     */
    public static function getRouter(){
        return self::$router;
    }

    public static function run($uri){
        self::$router = new Router($uri);
        self::$db = new DB(Config::get('db.host'), Config::get('db.user'),Config::get('db.password'),Config::get('db.db_name'));

        Lang::load(self::$router->getLanguage());

        $controller_class = ucfirst(self::$router->getController()).'Controller';

        $conrtoller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

        $layout = self::$router->getRoute();
        if ($layout == 'admin' && Session::get('role') != 'admin'){
            if ($conrtoller_method != 'admin_login'){
                Router::redirect('/admin/users/login');
            }
        }

        $conrtoller_object = new $controller_class();

        if (method_exists($conrtoller_object,$conrtoller_method)){
            //Controller's action may return a view path

            $view_path = $conrtoller_object->$conrtoller_method();
            $view_object = new View($conrtoller_object->getData(), $view_path);
            $content = $view_object->render();

        }else{
            throw new Exception('Method '.$conrtoller_method.' of class '.$controller_class.' does not exist.');
        }


        $layout_path = VIEWS_PATH.DS.$layout.'.html';
        $layout_view_object = new View ( compact('content'), $layout_path);
        echo $layout_view_object->render();



    }
}