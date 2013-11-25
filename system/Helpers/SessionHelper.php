<?php
    class SessionHelper{
        
        public static function setSession($name, $value){
            $_SESSION[$name] = $value;
        }
        
        public static function selectSession($name){
            return $_SESSION[$name];
        }
        
        public static function deleteSession($name){
            unset($_SESSION[$name]);
        }   
        
        public static function checkSession($name){
            return isset($_SESSION[$name]);
        }
        
        public static function setSystemSession($name, $valor, $temporary = true){
            $_SESSION['ODIN'][$name]['val'] = $valor;
            $_SESSION['ODIN'][$name]['tmp'] = $temporary;
        }
        
        public static function getSystemSession($name){
            if(isset($_SESSION['ODIN'][$name])){
                $par = $_SESSION['ODIN'][$name]['val'];
                if($_SESSION['ODIN'][$name]['tmp'])
                    unset($_SESSION['ODIN'][$name]);
                return $par;
            }else{
                return false;
            }                
        }
        
    }
