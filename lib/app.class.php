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
            $view_path = $conrtoller_object->$conrtoller_method();
            $view_object = new Views($conrtoller_object->getData().$view_path);
            $content = $view_object->render();


        }else{
            throw new Exception('Metod'.$conrtoller_method.'of class'.$controller_class.'does not exist');
        }

        $layout = self::$router->getRoute();
        $layout_path = VIEW_PATH.DS.$layout.'.html';
        $layout_view_object= new Views(compact('content',$layout_path));
        echo $layout_view_object->render();




    }
}