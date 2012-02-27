<?php
    /**
     * 
     * Helper for dates  
     * 
     * 
     * @package System
     * @author Renie Siqueira da Silva
     * @copyright Copyright (C) <2012>  <Renie Siqueira da Silva>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since 1.0
     */
    class DateHelper{
        
        /**
        * Get any date string from "Normal" format, assign on constants.php 
        * to "Database" format, assing on that same archive, and returns a 
        * formatted date.
        * @param string $date
        * @return string
        */
        public static function formatDateFromNormalToDatabase($date){
            $date = date_parse_from_format(NORMALDATEFORMAT, $date);
            return date(DATABASEDATEFORMAT, mktime(0, 0, 0, $date['month'], $date['day'], $date['year']));
        }
        
        /**
        * Get any date string from "Database" format, assign on constants.php 
        * to "Normal" format, assing on that same archive, and returns a 
        * formatted date.
        * @param string $date
        * @return string
        */
        public static function formatDateFromDatabaseToNormal($date){
            $date = date_parse_from_format(DATABASEDATEFORMAT, $date);
            return date(NORMALDATEFORMAT, mktime(0, 0, 0, $date['month'], $date['day'], $date['year']));
        }
        
        /**
        * Get any date string from "Normal" format, assign on constants.php 
        * to "Custom" format and returns a formatted date.
        * @param string $format
        * @param string $date
        * @return string
        */
        public static function formatDateFromNormalToCustom($format, $date){
            $date = date_parse_from_format(NORMALDATEFORMAT, $date);
            return date($format, mktime(0, 0, 0, $date['month'], $date['day'], $date['year']));
        }
        
        /**
        * Get any date string from "Custom" to "Normal" format, assign 
        * on constants.php and returns a formatted date.
        * @param string $format
        * @param string $date
        * @return string
        */
        public static function formatDateFromCustomToNormal($format, $date){
            $date = date_parse_from_format($format, $date);
            return date(NORMALDATEFORMAT, mktime(0, 0, 0, $date['month'], $date['day'], $date['year']));
        }
        
        /**
        * Get any time string from "Normal" format, assign on constants.php 
        * to "Database" format, assing on that same archive, and returns a 
        * formatted time.
        * @param string $time
        * @return string
        */
        public static function formatTimeFromNormalToDatabase($time){
            $time = date_parse_from_format(NORMALTIMEFORMAT, $time);
            return date(DATABASETIMEFORMAT, mktime($time['hour'], $time['minute'], $time['second'], 0, 0, 0));
        }
        
        /**
        * Get any time string from "Database" format, assign on constants.php 
        * to "Normal" format, assing on that same archive, and returns a 
        * formatted time.
        * @param string $time
        * @return string
        */
        public static function formatTimeFromDatabaseToNormal($time){
            $time = date_parse_from_format(DATABASETIMEFORMAT, $time);
            return date(NORMALTIMEFORMAT, mktime($time['hour'], $time['minute'], $time['second'], 0, 0, 0));
        }
        
        /**
        * Get any time string from "Normal" format, assign on constants.php 
        * to "Custom" format and returns a formatted time.
        * @param string $format
        * @param string $time
        * @return string
        */
        public static function formatTimeFromNormalToCustom($format, $time){
            $time = date_parse_from_format(NORMALTIMEFORMAT, $time);
            return date($format, mktime($time['hour'], $time['minute'], $time['second'], 0, 0, 0));
        }
        
        /**
        * Get any date string from "Custom" to "Normal" format, assign 
        * on constants.php and returns a formatted time.
        * @param string $format
        * @param string $time
        * @return string
        */
        public static function formatTimeFromCustomToNormal($format, $time){
            $time = date_parse_from_format($format, $time);
            return date(NORMALTIMEFORMAT, mktime($time['hour'], $time['minute'], $time['second'], 0, 0, 0));
        }
        
        /**
        * Get any datetime string from "Normal" format, assign on constants.php 
        * to "Database" format, assing on that same archive, and returns a 
        * formatted datetime.
        * @param string $datetime
        * @return string
        */
        public static function formatDateTimeFromNormalToDatabase($datetime){
            $datetime = date_parse_from_format(NORMALDATETIMEFORMAT, $datetime);   
            return date(DATABASEDATETIMEFORMAT, mktime($datetime['hour'], $datetime['minute'], $datetime['second'], $datetime['month'], $datetime['day'], $datetime['year']));
        }

        /**
        * Get any datetime string from "Database" format, assign on constants.php 
        * to "Normal" format, assing on that same archive, and returns a 
        * formatted datetime.
        * @param string $datetime
        * @return string
        */
        public static function formatDateTimeFromDatabaseToNormal($datetime){
            $datetime = date_parse_from_format(DATABASEDATETIMEFORMAT, $datetime);
            return date(NORMALDATETIMEFORMAT, mktime($datetime['hour'], $datetime['minute'], $datetime['second'], $datetime['month'], $datetime['day'], $datetime['year']));
        }
        
        /**
        * Get any datetime string from "Normal" format, assign on constants.php 
        * to "Custom" format and returns a formatted datetime.
        * @param string $format
        * @param string $datetime
        * @return string
        */
        public static function formatDateTimeFromNormalToCustom($format, $datetime){
            $datetime = date_parse_from_format(NORMALDATETIMEFORMAT, $datetime);
            return date($format, mktime($datetime['hour'], $datetime['minute'], $datetime['second'], $datetime['month'], $datetime['day'], $datetime['year']));
        }
        
        /**
        * Get any datetime string from "Custom" to "Normal" format, assign 
        * on constants.php and returns a formatted datetime.
        * @param string $format
        * @param string $datetime
        * @return string
        */
        public static function formatDateTimeFromCustomToNormal($format, $datetime){
            $datetime = date_parse_from_format($format, $datetime);
            return date(NORMALDATETIMEFORMAT, mktime($datetime['hour'], $datetime['minute'], $datetime['second'],$datetime['month'], $datetime['day'], $datetime['year']));
        }
        
    }
