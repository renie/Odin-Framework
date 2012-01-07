<?php
    
    define('SYSTEMNAME', 'Odin framework');  

    define('SYSTEM', 'system/');    
    define('HELPERS', 'system/helpers/');
    define('CONTROLLERS', 'app/controllers/');
    define('VIEWS', 'app/views/');
    define('MODELS', 'app/models/');
    define('DAO', 'app/dao/');
    
    $appName = explode("/",$_SERVER['PHP_SELF']);
    define('BASEURL', '/'.$appName[1].'/');
    define('IMG', '/'.$appName[1].'/assets/img');
    define('CSS', '/'.$appName[1].'/assets/css');
    define('JS', '/'.$appName[1].'/assets/js');
