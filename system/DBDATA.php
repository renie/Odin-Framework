<?php
    /**
     * This is an abstract class that stores all database data
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since 1.0
     */
    abstract class DBDATA{
        
        /**
         * Constant that stores database host
         * @access public
         * @var String 
         */
        const HOST     = "";
        
        /**
         * Constant that stores database name
         * @access public
         * @var String 
         */
        const DATABASE = "";
        
        /**
         * Constant that stores database username
         * @access public
         * @var String 
         */
        const USERNAME = "";
        
        /**
         * Constant that stores database password
         * @access public
         * @var String 
         */
        const PASSWORD = "";
    }