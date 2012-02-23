<?php
    class TestEmailController extends Controller {
        public function ini(){
            $email1 = "renie.webdev@gmail.com";
            $email1test = EmailHelper::validate($email1);
            $this->setVars("mail1", $email1test);
            
            $email2 = "renie.webdev@@gmail.com";
            $email2test = EmailHelper::validate($email2);
            $this->setVars("mail2", $email2test);
            
            $email3 = "renie.webdev@gmail.com.as.ds.ew.fd";
            $email3test = EmailHelper::validate($email3);
            $this->setVars("mail3", $email3test);
            
            $email4 = "renie.webdev@gmail.com.br";
            $email4test = EmailHelper::validate($email4);
            $this->setVars("mail4", $email4test);
            
            $email5 = "renie.web*dev@gmail.com";
            $email5test = EmailHelper::validate($email5);
            $this->setVars("mail5", $email5test);
            
            $this->view('testEmail');
        }
    }