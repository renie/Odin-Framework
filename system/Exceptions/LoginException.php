<?php

    class LoginException extends Exception{
        
        public function __construct() {
            parent::__construct("Login error. User and/or password is wrong.", 0);
        }

        public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
        
    }

?>
