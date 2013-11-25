<?php
    /**
     * 
     * Helper for e-mails  
     * 
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since 1.0
     */
    class EmailHelper{
        
        /**
        * Get an e-mail string and valides it, if it's on right format or not. 
        * @param string $email
        * @return boolean
        */
        public static function validate($email){
            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email))
                return true;
            else
                return false;
        }
        
    }
