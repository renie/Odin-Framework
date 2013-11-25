<?php
    class AuthHelper{
            
        public static function login($user, $pass){
            
            $conn   = mysql_connect(AUTHDBSERVER, AUTHDBUSER, AUTHDBPASS);
            $db     = mysql_select_db(AUTHDBNAME, $conn);

            $sql = "SELECT * FROM ".AUTHDBTABLE." WHERE ".AUTHDBUSERCOLUMN." ='".$user."' AND ".AUTHDBPASSCOLUMN." = MD5('".$pass."') LIMIT 1";
            $result = mysql_query($sql, $conn);
            
            if(mysql_fetch_assoc($result)){
                SessionHelper::setSession("valid", true);
                SessionHelper::setSession("userdata", $result);
                mysql_close($conn);
                return true;
            }else{
                mysql_close($conn);
                return false;
            }
            
        }
        
        public static function logout(){
            SessionHelper::deleteSession("valid");
        }
        
        public static function checkLogin(){
            
            if(SessionHelper::checkSession("valid") && SessionHelper::selectSession('valid') )
                return true;
            else
                return false;
        }
    }
