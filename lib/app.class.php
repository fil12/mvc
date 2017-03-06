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

    /**
     * @return mixed
     */
    public static function getRouter(){
        return self::$router;
    }

    public static function run($uri){
        self::$router = new Router($uri);

        $controller_class = ucfirst(self::$router->getController()).'Controller';
        $conrtoller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

        $conrtoller_object = new $controller_class();

        if (method_exists($conrtoller_object,$conrtoller_method)){
            $result = $conrtoller_object->$conrtoller_method();
        }



    }
}