<?php
    class TestDateController extends Controller {
        public function ini(){
            $date1 = date(NORMALDATEFORMAT);
            $date1test = DateHelper::formatDateFromNormalToDatabase($date1);
            $this->setVars("pureDate1", $date1);
            $this->setVars("formattedDate1", $date1test);
            
            $date2 = date(DATABASEDATEFORMAT);
            $date2test = DateHelper::formatDateFromDatabaseToNormal($date2);
            $this->setVars("pureDate2", $date2);
            $this->setVars("formattedDate2", $date2test);
            
            $date3 = date(NORMALDATEFORMAT);
            $date3test = DateHelper::formatDateFromNormalToCustom('d#m#Y', $date3);
            $this->setVars("pureDate3", $date3);
            $this->setVars("formattedDate3", $date3test);
            
            $date4 = date('d#m#Y');
            $date4test = DateHelper::formatDateFromCustomToNormal('d#m#Y', $date4);
            $this->setVars("pureDate4", $date4);
            $this->setVars("formattedDate4", $date4test);
            
            $time1 = date(NORMALTIMEFORMAT);
            $time1test = DateHelper::formatTimeFromNormalToDatabase($time1);
            $this->setVars("pureTime1", $time1);
            $this->setVars("formattedTime1", $time1test);
            
            $time2 = date(DATABASETIMEFORMAT);
            $time2test = DateHelper::formatTimeFromDatabaseToNormal($time2);
            $this->setVars("pureTime2", $time2);
            $this->setVars("formattedTime2", $time2test);
            
            $time3 = date(NORMALTIMEFORMAT);
            $time3test = DateHelper::formatTimeFromNormalToCustom("H#i#s", $time3);
            $this->setVars("pureTime3", $time3);
            $this->setVars("formattedTime3", $time3test);
            
            $time4 = date('H#i#s');
            $time4test = DateHelper::formatTimeFromCustomToNormal("H#i#s", $time4);
            $this->setVars("pureTime4", $time4);
            $this->setVars("formattedTime4", $time4test);
            
            $dateTime1 = date(NORMALDATETIMEFORMAT);
            $dateTime1test = DateHelper::formatDateTimeFromNormalToDatabase($dateTime1);
            $this->setVars("pureDateTime1", $dateTime1);
            $this->setVars("formattedDateTime1", $dateTime1test);
            
            $dateTime2 = date(DATABASEDATETIMEFORMAT);
            $dateTime2test = DateHelper::formatDateTimeFromDatabaseToNormal($dateTime2);
            $this->setVars("pureDateTime2", $dateTime2);
            $this->setVars("formattedDateTime2", $dateTime2test);
            
            $dateTime3 = date(NORMALDATETIMEFORMAT);
            $dateTime3test = DateHelper::formatDateTimeFromNormalToCustom("d#m#Y H#i#s", $dateTime3);
            $this->setVars("pureDateTime3", $dateTime3);
            $this->setVars("formattedDateTime3", $dateTime3test);
            
            $dateTime4 = date('d#m#Y H#i#s');
            $dateTime4test = DateHelper::formatDateTimeFromCustomToNormal("d#m#Y H#i#s", $dateTime4);
            $this->setVars("pureDateTime4", $dateTime4);
            $this->setVars("formattedDateTime4", $dateTime4test);
            
            $this->view('testDate');
        }
    }