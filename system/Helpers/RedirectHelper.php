<?php

    class RedirectHelper{
        
        protected $params = array();
        
        protected function go($url){
            $appName = explode("/",$_SERVER['PHP_SELF']);
            header("Location: /".$appName[1].'/'.$url);
        }
        
        public function setUrlParameter($name, $value){
            $this->params[$name] = $value;
            return $this;
        }
        
        protected function getUrlParameters(){
            $params = "";
            foreach ($this->params as $name => $value) {
                $params .= $name.'/'.$value.'/';
            }
            return $params;
        }
        
        public function goToController($controller){
            $this->go($controller);
        }
        
        public function goToAction($action){
            if($action==DEFAULTACTION)
                $this->go($this->getCurrentController());
            else
                $this->go($this->getCurrentController().'/'.$action.'/'.$this->getUrlParameters());
        }
        
        public function goToControllerAction($controller, $action){
            if($action==DEFAULTACTION && $controller==DEFAULTCONTROLLER)
                $this->go("");
            else if($action=="DEFAULTACTION")
                $this->go($controller);
            else
                $this->go($controller.'/'.$action.'/'.$this->getUrlParameters());
             
        }

        public function goToIndex(){
            $this->goToController(DEFAULTCONTROLLER);
        }
        
        public static function goToUrl($url){
            if(!strstr($url, "http://") && !strstr($url, "https://"))
                $url = "http://".$url;
            
            header("Location: ".$url);
        }
        
        public function getCurrentController(){
            global $start;
            return strtolower($start->_controller);
        }
        
        public function getCurrentAction(){
            global $start;
            return strtolower($start->_action);
        }
        
    }
