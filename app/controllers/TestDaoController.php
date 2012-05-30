<?php

    class TestDaoController extends Controller {
        public function ini(){
            $this->view('testDaoInsert');
        }
        
        public function put(){
            $obj = new Teste();
            $obj->setName(System::$PARAMS['name'])
                ->setXpto(System::$PARAMS['xpto']);
            
            if($obj->insert())
                echo 'Create success!';
        }
        
        public function del(){
            $obj = new Teste();
            $obj->setId(System::$PARAMS['id']);
            
            if($obj->delete())
                echo 'Deletado success!';
        }
        
        public function listAll(){
            $obj = new Teste();
            $result = $obj->listAll();
            echo "<ul>";
            $count = 0;

            foreach ($result as $item) {
                echo "<li>Registro: ".$count++;
                echo "<ul>";
                echo "<li>";
                echo $item->id;
                echo "</li>";
                echo "<li>";
                echo $item->name;
                echo "</li>";
                echo "<li>";
                echo $item->xpto;
                echo "</li>";
                echo "</ul>";
                echo "</li>";
            }
            echo "</ul>";
        }
        
        /**
        *@TODO What a fucking update test is that? id you doesn't pass one param, BUG
        */
        public function up(){
            $obj = new Teste();
            $obj->setName(System::$PARAMS['name'])
                ->setXpto(System::$PARAMS['xpto']);
                
            if($obj->update('id = '.System::$PARAMS['id']))
                echo 'Update success!';
        }
    }