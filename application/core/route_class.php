<?php

class Route {
    
    public static function start() {
        $controller_name = 'Main';
        $action_name = 'index';
        
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = substr($uri, 1);
        
        //echo "uri = ".$uri.'<br />';
//        print_r($_REQUEST);
//        echo '<br />';
        $arr = parse_url($uri);        
        //$_SESSION['uri'] = $arr;
        //print_r($arr);
//        echo '<br />';
    
        
        if ($uri) $action_name = $arr['path'];
        $controller_name = $controller_name.'Controller';
        $action_name = 'action'.$action_name;
        $controller = new $controller_name();
        //echo 'action_name = '.$action_name.' controller_name = '.$controller_name.'<br />';
        if (method_exists($controller, $action_name)) $controller->$action_name();
        else $controller->action404();
    }
}

?>