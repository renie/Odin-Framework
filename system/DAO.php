<?php
    class DAO{
        
        public $connection;
        protected $selectedDB;
        
        public function __construct(){
            $this->openConnection(); 
        }
        public function __destruct() {
            $this->closeConnection();
        }
        
        private function closeConnection(){
            mysql_close($this->connection);
        }
        
        private function openConnection(){
            $this->connection = mysql_connect(DBDATA::HOST, DBDATA::USERNAME, DBDATA::PASSWORD);
            $this->selectedDB = mysql_select_db(DBDATA::DATABASE, $this->connection);
        }
    }