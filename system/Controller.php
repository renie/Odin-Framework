<?php
    class Controller extends System{
        
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

