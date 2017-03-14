<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of router
 *
 * @author Alex
 */
class Router {

    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;
    protected $methodPrefix;
    protected $language;

    public function getUri() {
        return $this->uri;
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function getParams() {
        return $this->params;
    }

    public function getRoute() {
        return $this->route;
    }
    
    public function getMethodPrefix() {
        return $this->methodPrefix;
    }
    
    public function getLanguage() {
        return $this->language;
    }


    public function __construct($uri) {
        $this->uri = urldecode(trim($uri,'/'));

        //Get default
        $routes = Config::get('routes');
        $this->route = Config::get('default_route');
        $this->MethodPrefix = isset($routes[$this->route]) ? $routes[$this->route] : '' ;
        $this->language = Config::get('default_language');
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');

        $uri_parts = explode('?',$this->uri);

        $path = $uri_parts[0];
        $path_parts = explode('/',$path);



        if (count($path_parts)){
            if (in_array(strtolower(current($path_parts)),array_keys($routes))){
                $this->route = strtolower(current($path_parts));
                $this->methodPrefix = isset($routes[$this->route]) ? $routes[$this->route]:'';
                array_shift($path_parts);
            }elseif (in_array(strtolower(current($path_parts)),Config::get('languages'))){
                $this->language = strtolower(current($path_parts));
                array_shift($path_parts);
            }

         if (current($path_parts)){
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
         }
         if (current($path_parts)){
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
         }

         $this->params = $path_parts;
        }

        $this->uri = $uri;
    }

    public static function redirect($redirect_url){
        header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
    }

}
