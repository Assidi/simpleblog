<?php    
    require_once 'config.php';
    set_include_path(get_include_path().PATH_SEPARATOR.'application/core'.PATH_SEPARATOR.'application/controllers'.PATH_SEPARATOR.'application/models'.PATH_SEPARATOR.'application/helper');
    spl_autoload_extensions('_class.php');
    spl_autoload_register();
    
    
    
?>