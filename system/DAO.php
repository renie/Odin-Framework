<?php
    /**
     * This is a super-class that all DAO classes must extends.
     * 
     * At the moment this framework just supports MySQL databases
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @version 1.0
     * @since 1.0
     */
    class DAO{
        
        /**
         * Stores database conection
         * @access public
         * @var connection 
         */
        public $connection;
        
        /**
         * Stores database selected
         * @access public
         * @var connection 
         */
        protected $selectedDB;
        
        /**
         * When a new object is built a new connection is opened
         * @access public
         * @author Renie Siqueira da Silva
         * @version 1.0
         * @since 1.0
         * @return new Dao object
         */
        public function __construct(){
            $this->openConnection(); 
        }
        
        /**
         * When an object is destroyed the connection is closed
         * @access public
         * @author Renie Siqueira da Silva
         * @version 1.0
         * @since 1.0
         * @return void
         */
        public function __destruct() {
            $this->closeConnection();
        }
        
        /**
         * Closes database conection
         * @access private
         * @author Renie Siqueira da Silva
         * @version 1.0
         * @since 1.0
         * @return void
         */
        private function closeConnection(){
            mysql_close($this->connection);
        }
        
        /**
         * Opens database conection
         * @access private
         * @author Renie Siqueira da Silva
         * @version 1.0
         * @since 1.0
         * @return void 
         */
        private function openConnection(){
            $this->connection = mysql_connect(DBDATA::HOST, DBDATA::USERNAME, DBDATA::PASSWORD);
            $this->selectedDB = mysql_select_db(DBDATA::DATABASE, $this->connection);
        }
    }