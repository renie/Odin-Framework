<?php

    class System{
        
        private $_url;
        private $_explode;
        public $_controller;
        public $_action;
        public $_params;
        
    
        public function __construct(){
            $this->setUrl();
            $this->setExplode();
            if($this->setController()){
                if($this->setAction()){
                    $this->setParams();
                }else{
                    $this->dispatch404();
                }
            }
            else{
                $this->dispatch404();
            }
        }
        
        private function setUrl(){
            $_GET['key'] = (isset($_GET['key'])?$_GET['key']:"Index/indexAction");
            $this->_url = $_GET['key'];
            
        }
        
        private function setExplode(){
            $this->_explode = explode("/", $this->_url);
            return true;
        }
        
        private function setController(){
            $this->_controller = $this->_explode[0];
            return true;
        }
        
        private function setAction(){
            if(!isset($this->_explode[1]) || $this->_explode[1]==null)
                $this->_explode[1] = 'indexAction';
                
            $this->_action = $this->_explode[1];
            return true;
        }
        
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
                        $values[] = $val;
                    $parity++;
                }
            }else{
                $indexes = array();
                $values  = array();
            }
                
            if((empty($indexes) && !empty($values))||(!empty($indexes) && empty($values)))
                $this->dispatch404();
            else if(!empty($indexes) && !empty($values) && count($indexes) == count($values))
                $this->_params = array_combine($indexes, $values);
            else
                $this->_params = array();

        }
        
        public function getParam($name = null){
            if($name != null)
                return $this->_params[$name];
            else
                return $this->_params;
        }
        
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
            
            try{
            $app->$action();
            }  catch (Exception $e)
            {
                echo $e;
            }
        }
        
        public function dispatch404(){
            $redirect = new RedirectHelper();
            $redirect->goToController("pagina_nao_encontrada");
            
        }
        
        public static function getPureController(){
            global $start;
            return strtolower($start->_controller);
         }
        
        public static function getPureAction(){
           global $start;
           return strtolower($start->_action);
        }
        
        public static function getController(){
            global $start;
            $a = array_keys($start->controllers, $start->_controller);
            return strtolower($a[0]);   
        }
        
        public static function getAction(){
            global $start;
            $a = array_keys($start->actions, $start->_action);
            return strtolower($a[0]);
        }
    }
