<?php

    class IndexController extends Controller{
        
        public function indexAction(){
            $this->view('index');       
        }
        
        public function teste(){
            echo "massa";       
        }
    
    }
