<?php
    class SessionHelper{
        
        public function createSession($name, $value){
            $_SESSION[$name] = $value;
            return $this;
        }
        
        public function selectSession($name){
            return $_SESSION[$name];
        }
        
        public function deleteSession($name){
            unset($_SESSION[$name]);
            return $this;
        }   
        
        public function checkSession($name){
            return isset($_SESSION[$name]);
        }
        
        
        
    }
