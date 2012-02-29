<?php

    class TestAuthenticationController extends Controller {
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
                if(AuthHelper::checkLogin()){
                    $this->view('testAuthLoginOk');
                }
                else{
                    if(isset(System::$PARAMS['user']) && isset(SYSTEM::$PARAMS['pass']) && AuthHelper::login(System::$PARAMS['user'], SYSTEM::$PARAMS['pass'])){
                        $this->view('testAuthLoginOk');
                    }else{
                        SessionHelper::setSystemSession('msg', 'Login error.');
                        RedirectHelper::goToController("TestAuthentication");
                    }
                }
                    
        }
        public function gtfo(){
                AuthHelper::logout();
                SessionHelper::setSystemSession('msg', 'You are not logged anymore.');
                RedirectHelper::goToController("TestAuthentication");            
        }
    }

?>
