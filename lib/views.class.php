<?php

class Views {

    protected $data;
    protected $path;

    protected static function getDefaultViewPath(){
        $router = App::getRouter();
        if (!$router){
            return false;
        }
        $controller_dir = $router->getController();
        $tamplate_name = $router->getMethodPrefix().$router->getAction().'.html';
        return VIEW_PATH.DS.$controller_dir.DS.$tamplate_name;
    }

    public function __construct($data = array(),$path = null){
        if (!$path){
            $path = self::getDefaultViewPath();
        }
        if (!file_exists($path)){

            throw new Exception("файл не найден по пути:".$path);
        }
        $this->path=$path;
        $this->data=$data;

    }

    public function render(){
        $data = $this->data;

        ob_start();
        include ($this->path);
        $content = ob_get_clean();

        return $content;
    }


}