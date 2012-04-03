<?php
    /**
     * Core class
     * 
     * At this moment this class just controls the controllers access and
     * friendly url.
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since 1.0
     */
    class System{
        
        /**
         * Stores full URL
         * @access private
         * @var String 
         */        
        private $_url;

        /**
         * Stores a broken URL
         * @access private
         * @var String 
         */        
        private $_explode;
        
        /**
         * Stores controller name
         * @access public
         * @var String 
         */
        public $_controller;
        
        /**
         * Stores action name
         * @access public
         * @var String 
         */
        public $_action;
        
        /**
         * Stores all params
         * @access public
         * @var String 
         */
        public static $PARAMS;
        
        /**
         * Calls methods that boot all variables
         * 
         * @access public
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return new System object
         */
        public function __construct(){
            
            $this->setUrl();
            $this->setExplode();
            $this->setController();
            $this->setAction();
            $this->setParams();
        }
        
        /**
         * Sets up url
         * 
         * @access private
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return void
         */
        private function setUrl(){
            
            $_GET['key'] = (isset($_GET['key'])?$_GET['key']:DEFAULTCONTROLLER."/".DEFAULTACTION);
            $this->_url = $_GET['key'];
            
        }
        
        /**
         * Sets up explode variable
         * 
         * @access private
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return void
         */
        private function setExplode(){
            $this->_explode = explode("/", $this->_url);
        }
        
        /**
         * Sets up controller variable
         * 
         * @access private
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return void
         */
        private function setController(){
            $this->_controller = $this->_explode[0];
        }
        
        /**
         * Sets up actions variable
         * 
         * @access private
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return void
         */
        private function setAction(){
            if(!isset($this->_explode[1]) || $this->_explode[1]==null)
                $this->_explode[1] = DEFAULTACTION;
            
            $this->_action = $this->_explode[1];
        }
        
        /**
         * Sets up params variable
         * 
         * @access private
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return void
         */
        private function setParams(){
            unset($this->_explode[0], $this->_explode[1]);

            if(end($this->_explode)== null)
                array_pop($this->_explode);

            if(!empty ($this->_explode)){
                $parity = 0;
                foreach( $this->_explode as $val ){
                    if($parity % 2 == 0)
                        $indexes[] = $val;
                    else
                        $values[] = addslashes($val);
                    $parity++;
                }
            }
            if($_POST){
                foreach( $_POST as $k => $v ){
                    $indexes[] = $k;
                    $values[] = addslashes($v);
                }
            }
            if($_FILES){
                foreach( $_FILES as $k => $v ){
                    $indexes[] = $k;
                    $values[] = $v;
                }
            }
                
            if((empty($indexes) && !empty($values))||(!empty($indexes) && empty($values)))
                $this->dispatch404();
            else if(!empty($indexes) && !empty($values) && count($indexes) == count($values))
                System::$PARAMS = array_combine($indexes, $values);
            else
                System::$PARAMS = array();
        }
             
        /**
         * Loads the requested URL
         * 
         * @access public
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return void
         */
        public function run(){
            $controller_path = CONTROLLERS.$this->_controller."Controller.php";
            
            if(!file_exists($controller_path)){
                $this->dispatch404();
            }

            require_once($controller_path);
            $controller = $this->_controller."Controller";
            $app = new $controller();
            
            if(!method_exists($app, $this->_action))
                $this->dispatch404();
            
            $action = $this->_action;

            if(defined('AUTHENABLE') && AUTHENABLE){

                $refM = new ReflectionMethod($controller, $action);
                $refC = new ReflectionClass($controller);

                $authMNeeded = array();
                preg_match("/@OdinAuth /", $refM->getDocComment(), $authMNeeded);
                
                $authCNeeded = array();
                preg_match("/@OdinAuth /", $refC->getDocComment(), $authCNeeded);

                $authLogin = array();
                preg_match("/@OdinAuthLogin /", $refM->getDocComment(), $authLogin);
                
                if(isset($authMNeeded[0]) || isset($authCNeeded[0])){
                    if(!AuthHelper::checkLogin()){
                        if(defined('AUTHCONTROLLERERROR') && AUTHCONTROLLERERROR != ""){
                            SessionHelper::setSystemSession('requiredController', $this->_controller);
                            SessionHelper::setSystemSession('requiredAction', $this->_action);
                            SessionHelper::setSystemSession('requiredURL', true);
                            if(defined('AUTHCONTROLLERACTION') && AUTHCONTROLLERACTION != ""){
                                RedirectHelper::goToControllerAction(AUTHCONTROLLERERROR, AUTHACTIONERROR);
                            }else{
                                RedirectHelper::goToController(AUTHCONTROLLERERROR);
                            }
                        }else{
                            RedirectHelper::goToIndex();
                        }
                    }
                }elseif(isset($authLogin[0])){
                    
                    if(AuthHelper::checkLogin()){
                        if(defined('AUTHCONTROLLERHOME') && AUTHCONTROLLERHOME != ""){
                            if((defined('AUTHACTIONHOME') && AUTHACTIONHOME != "") && ((AUTHCONTROLLERHOME != AUTHCONTROLLERERROR && AUTHACTIONHOME != AUTHACTIONERROR)||(AUTHACTIONHOME != AUTHACTIONERROR)||(AUTHCONTROLLERHOME != AUTHCONTROLLERERROR))){
                                RedirectHelper::goToControllerAction(AUTHCONTROLLERHOME, AUTHACTIONHOME);
                                exit;
                            }else{
                                RedirectHelper::goToUrl("odinphp.com/Fury");
                                exit;
                            }
                        }else{
                            RedirectHelper::goToUrl("odinphp.com/Fury");
                            exit;
                        }
                    }
                    
                }
            }
            
            try{
                $app->$action();
            }  catch (Exception $e)
            {
                echo $e;
            }
        }
        
        /**
         * Calls controller for page not found(404 error)
         * 
         * @access public
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return void
         */
        public function dispatch404(){
            RedirectHelper::goToController(DEFAULT404ERRORCONTROLLER);        
        }
        
        /**
         * Gets controller's name in lower case
         * 
         * @access public
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return String
         */
        public static function getPureController(){
            global $start;
            return strtolower($start->_controller);
        }
        
        /**
         * Gets action's name in lower case
         * 
         * @access public
         * @author Renie Siqueira da Silva
         * @since 1.0
         * @return String
         */
        public static function getPureAction(){
           global $start;
           return strtolower($start->_action);
        }
        
    }
