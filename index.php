<?php

    session_start();
    
    require_once('system/constants.php');
    require_once('system/System.php');
    require_once('system/Controller.php');
    require_once('system/DAO.php');
    
   
    /**
     * When some specific controller calls try to instance a new model
     * this function will load that file
     */
    function __autoload($file)
    {
        if(file_exists(MODELS.$file.'.php'))
            require_once(MODELS.$file.'.php');
        else if(file_exists(DAO.$file.'.php'))
            require_once(DAO.$file.'.php');
        else if(file_exists(HELPERS.$file.'.php'))
            require_once(HELPERS.$file.'.php');
        else if(file_exists(CONTROLLERS.$file.'.php'))
            require_once(CONTROLLERS.$file.'.php');
        else if(file_exists(SYSTEM.$file.'.php'))
            require_once(SYSTEM.$file.'.php');
        else
            die('Injection could not be done. File not found: '.$file);
    }

    $start = new System();
    $start->run();
