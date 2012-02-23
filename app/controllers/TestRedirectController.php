<?php

    class TestRedirectController extends Controller {
        public function ini(){
            $this->view('testRedirect');
        }
        public function goToGoogle(){
            RedirectHelper::goToUrl("http://www.google.com.br");
        }
    }