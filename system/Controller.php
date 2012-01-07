<?php
    /**
     * This is a super-class that all Controller classes must extends
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @version 1.0
     * @since 1.0
     */
    class Controller extends System{
        
        /**
         * Loads required view and treat the parameters.
         * 
         * Receives name of View and variables will be available into.
         * If variable is an array, it will be broken in indepentent variables
         * that will be named with the key concatenated with string "view". Therefore
         * an array like array("name"=>"foo","id"=>0) can be accessed into view page
         * as $name and $id.
         * This method will include the required phtml file.
         * 
         * @access protected
         * @author Renie Siqueira da Silva
         * @version 1.0
         * @since 1.0
         * @param String $viewName
         * @param Array or String $vars
         * @return void
         */
        protected function view($viewName, $vars = null){
            if(is_array($vars) && count($vars)>0)
                extract($vars, EXTR_PREFIX_ALL, 'view');
            
            $pure_controller    = SYSTEM::getPureController();
            $pure_action        = SYSTEM::getPureAction();
            $controller         = strtoupper(SYSTEM::getController());
            $action             = strtoupper(SYSTEM::getAction());
            
            return require_once('app/views/'.$viewName.'.phtml');
        }
        
    }

