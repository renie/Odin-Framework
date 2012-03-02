<?php

    class TestAuthenticationController extends Controller {
        /**
         *@OdinAuthLogin 
         */
        public function ini(){
               $msg = SessionHelper::getSystemSession('msg');
                if(AuthHelper::checkLogin()){
                    RedirectHelper::goToControllerAction("TestAuthentication", "getin");
                }else if(!$msg){
                    $this->view('testAuthLogin');
                }else{
                    $this->setVars("msg", $msg);
                    $this->view('testAuthLogin');
                }                
        }
        
        public function getin(){
            if(isset(System::$PARAMS['user']) && isset(SYSTEM::$PARAMS['pass']) && AuthHelper::login(System::$PARAMS['user'], SYSTEM::$PARAMS['pass'])){
                $c = SessionHelper::getSystemSession('requiredController');
                $a = SessionHelper::getSystemSession('requiredAction');
                $r = SessionHelper::getSystemSession('requiredURL');
                if($r && ($c && $a)){
                    RedirectHelper::goToControllerAction ($c, $a);
                }else{
                    RedirectHelper::goToControllerAction(AUTHCONTROLLERHOME, AUTHACTIONHOME);
                }
            }else{
                SessionHelper::setSystemSession('msg', 'Login error.');
                RedirectHelper::goToController(AUTHACTIONERROR);
            }                    
        }
        /**
         *@OdinAuth 
         */
        public function gtfo(){
                AuthHelper::logout();
                SessionHelper::setSystemSession('msg', 'You are not logged anymore.');
                RedirectHelper::goToController("TestAuthentication");            
        }
        /**
         *@OdinAuth 
         */
        public function restrictedByAnnotation(){
            $this->view('testAuthLoginOk');
        }
    }

?>
