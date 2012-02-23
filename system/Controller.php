<?php
    /**
     * This is a super-class that all Controller classes must extends
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since 1.0
     */
    class Controller{
        
        /**
         * Stores parameters
         * @access private
         * @var array 
         */
        private $vars;
        
        /**
         * Loads required view and treat the parameters.
         * 
         * Receives name of View.
         * Parameters must to be setted on {setVars} method.
         * {vars} will be broken in indepentent variables
         * that will be named with the key concatenated with string "view_". Therefore
         * an array like array("name"=>"foo","id"=>0) can be accessed into view page
         * as $view_name and $_viewid.
         * This method will include the required phtml file.
         * 
         * @access protected
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @param String $viewName
         * @return void
         */
        protected function view($viewName){
            if(count($this->vars)>0)
                extract($this->vars, EXTR_PREFIX_ALL, 'view');
            
            $controller    = SYSTEM::getPureController();
            $controllerIdentification = $controller;
            
            if($controller == 'odin')
                $controller = 'Home';
            else if($controller == 'error404')
                $controller = 'Page not found';
            else
                $controller = strtoupper(substr($controller, 0, 1).substr($controller, 1, -1));
            
            $action        = SYSTEM::getPureAction();
            $actionIdentification = $action;
            if($action == 'ini')
                $action = '';
            else 
                $action = strtoupper(substr($action, 0, 1).substr($action, 1, -1));
            
            
            
            return require_once('app/views/'.$viewName.'.phtml');
        }
        
        /**
         * Receive parameters will be accessed on view.
         * 
         * @access protected
         * @author Renie Siqueira da Silva
         * @since 1.0.1
         * @param String $viewName
         * @return void
         */
        protected function setVars($name, $value){
            $this->vars[$name] = $value;
            return $this;
        }
        
    }

