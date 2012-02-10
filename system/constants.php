<?php
    /**
     * The contants archive. 
     * 
     * This contains system's name, path to system', helpers', controllers', 
     * views', models', daos', cascading style sheets', images' and 
     * javascript scripts' folders and base url  
     * 
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since 1.0
     */    
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
