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
    define('DEFAULTCONTROLLER', 'Odin'); //'index' are not recommended
    define('DEFAULTACTION', 'ini'); //'index' are not recommended
    define('DEFAULT404ERRORCONTROLLER', 'Error404'); //'index' are not recommended

    define('SYSTEM', 'system/');    
    define('HELPERS', 'system/Helpers/');
    
    define('CONTROLLERS', 'app/controllers/');
    define('VIEWS', 'app/views/');
    define('MODELS', 'app/models/');
    define('DAO', 'app/dao/');
    
    
    
    $appName = explode("/",$_SERVER['PHP_SELF']);
    /**
     * System's url
     */
    define('BASEURL', '/'.$appName[1].'/');
    
    /**
     * Image's url
     */
    define('IMG', '/'.$appName[1].'/assets/img');
    
    /**
     * Stylesheets url
     */
    define('CSS', '/'.$appName[1].'/assets/css');
    
    /**
     * Javascript archives url
     */
    define('JS', '/'.$appName[1].'/assets/js');
    
    
    
    /**
     * Enable Helper for Authentication
     */
    define('AUTHENABLE', true);
    
    /**
     * Database server where AuthHelper should verify
     */
    define('AUTHDBSERVER', 'localhost');
    
    /**
     * Database name where AuthHelper should verify
     */
    define('AUTHDBNAME', 'odin_auth_test');
    
    /**
     * Database username to AuthHelper get access on database
     */
    define('AUTHDBUSER', 'odinAuth');
    
    /**
     * Database password to AuthHelper get access  on database
     */
    define('AUTHDBPASS', 'oat');
    
    /**
     * Database table where AuthHelper should verify
     */
    define('AUTHDBTABLE', 'auth_table');
    
    /**
     * Database usercolumn on authdbtable where AuthHelper should verify
     */
    define('AUTHDBUSERCOLUMN', 'user');
    
    /**
     * Database passwordcolumn on authdbtable where AuthHelper should verify
     */
    define('AUTHDBPASSCOLUMN', 'pass');
    
    /**
     * Controller where user will be redirect if try to access a protected page.
     * If It's not settef, default will be DEFAULTCONTROLLER
     */
    define('AUTHCONTROLLERERROR', 'TestAuthentication');
    
    /**
     * Action, of above Controller, where user will be redirect if try to 
     * access a protected page.
     * If It's not settef, default will be DEFAULTACTION
     */
    define('AUTHACTIONERROR', 'ini');
    
    
    /**
     * Controller where user will be redirect if try to access a protected page.
     * NO DEFAULT, IF IT'S NOT SETTED APOCALYPSE WILL START
     */
    define('AUTHCONTROLLERHOME', 'TestAuthentication');
    
    /**
     * Action, of above Controller, where user will be redirect if try to 
     * access a protected page.
     * NO DEFAULT AND CANNOT SAME OF AUTHACTIONERROR!
     * IF IT'S NOT SETTED APOCALYPSE WILL START
     */
    define('AUTHACTIONHOME', 'restrictedByAnnotation');
    
    
    
    /**
     * "Normal" date format
     */
    define('NORMALDATEFORMAT', 'd/m/Y');//php date format
    
    /**
     * "Normal" time format
     */
    define('NORMALTIMEFORMAT', 'H\hi\ms\s');//php time format
    
    /**
     * "Normal" datetime format
     */
    define('NORMALDATETIMEFORMAT', 'd/m/Y\ H\hi\ms\s');//php datetime format
    
    /**
     * "Datebase" date format
     */
    define('DATABASEDATEFORMAT', 'Y-m-d');//php datetime format
    
    /**
     * "Database" time format
     */
    define('DATABASETIMEFORMAT', 'H:i:s');//php datetime format
    
    /**
     * "Database" datetime format
     */
    define('DATABASEDATETIMEFORMAT', 'Y-m-d H:i:s');//php datetime format
 