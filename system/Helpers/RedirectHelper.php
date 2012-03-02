<?php
    /**
     * 
     * Helper for redirects 
     * 
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since 1.0
     */
    class RedirectHelper{
        
        protected static $params = array();
        
        protected static function go($url){
            $appName = explode("/",$_SERVER['PHP_SELF']);
            header("Location: /".$appName[1].'/'.$url);
        }
        
        public function setUrlParameter($name, $value){
            RedirectHelper::$params[$name] = $value;
            return $this;
        }
        
        protected static function getUrlParameters(){
            $params = "";
            foreach (RedirectHelper::$params as $name => $value) {
                $params .= $name.'/'.$value.'/';
            }
            return $params;
        }
        
        public static function goToController($controller){
            RedirectHelper::go($controller);
        }
        
        public function goToAction($action){
            if($action==DEFAULTACTION)
                RedirectHelper::go($this->getCurrentController());
            else
                RedirectHelper::go($this->getCurrentController().'/'.$action.'/'.RedirectHelper::getUrlParameters());
        }
        
        public static function goToControllerAction($controller, $action){
            if($action==DEFAULTACTION && $controller==DEFAULTCONTROLLER)
                RedirectHelper::go("");
            else if($action==DEFAULTACTION)
                RedirectHelper::go($controller);
            else
                RedirectHelper::go($controller.'/'.$action.'/'.RedirectHelper::getUrlParameters());
             
        }

        public static function goToIndex(){
            RedirectHelper::goToController(DEFAULTCONTROLLER);
        }
        
        /**
        * Get an URL and redirect to this 
        * @param string url
        * @return void
        */
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
