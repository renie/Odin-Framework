<?php
abstract class DAO{

    protected $connection;
    protected $selectedDB;
    private $refObj;
    private $class;
    private $properties;
    private $table;
    private $columns;
    private $sql;

    protected function closeConnection(){
        mysql_close($this->connection);
    }

    protected function openConnection(){
        $this->connection = mysql_connect(APPDBSERVER, APPDBUSER, APPDBPASS);
        $this->selectedDB = mysql_select_db(APPDBNAME, $this->connection);
    }
    
    protected function startReflection(){
        $this->class        = get_class($this);
        $refClass           = new ReflectionClass($this->class);
        $this->properties   = $refClass->getProperties();
        
        //set table name
        $tableNameArr   = array();
        preg_match("/(@Tablename )(.*)/", $refClass->getDocComment(), $tableNameArr);
        if(isset($tableNameArr[0]))
            $this->table  = $tableNameArr[2];
        else
            $this->table  = strtolower($this->class);
        
        
        //set columns
        $cont = 0;
        foreach($this->properties as $prop){
            if($prop->class != "DAO"){
                $columnNamesArr = array();
                $refProp        = new ReflectionProperty($this->class, $prop->name);

                preg_match("/(@Columnname )(.*)/", $refProp->getDocComment(), $columnNamesArr);
                preg_match("/(@Columntype )(.*)/", $refProp->getDocComment(), $columnTypesArr);
                $this->columns[$cont]['name']       = $prop->name;
                
                if(isset($columnNamesArr[0]))
                    $this->columns[$cont]['column'] = $columnNamesArr[2];
                else
                    $this->columns[$cont]['column'] = strtolower($prop->name); 
                
                $this->columns[$cont]['type']       = isset($columnTypesArr[2])?$columnTypesArr[2]:'string';
                $cont++;
            }
        }
        
        //reflection object
        $this->refObj = new ReflectionObject($this);        
    }
    
    public function insert(){
        $this->startReflection();
        $this->sql  = "INSERT INTO ".$this->table." ";
        $this->sql .= "(";
        $values = array();
        $cont = 0;
        foreach($this->columns as $prop){
            $propertyRef = $this->refObj->getProperty($prop['name']);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            if(!empty($propertyVal)){
                $cont++;
                if($cont != 1)
                    $this->sql .= ",";
                
                $values[$cont]['val']      = $propertyVal;
                $values[$cont]['type']     = $prop['type'];
                $this->sql .= $prop['column'];

            }
        }
        $this->sql .= ") VALUES(";
        $cont = 0;
        foreach($values as $value){
            $cont++;
            if($cont != 1)
                $this->sql .= ",";
            if($value['type']=='string' || $value['type']=='date')
                $this->sql .= "'".$value['val']."'";
            else if($value['type']=='int' || $value['type']=='bool')
                $this->sql .= $value['val'];
            else 
                die("Unknown data type for value ".$value['val']." !!");
               
        }
        $this->sql .= ");";
        
        return $this->execQuery();

    }
    
    public function update($condition=null){
        $this->startReflection();
        $this->sql  = "UPDATE ".$this->table." SET ";
        $values = array();
        $cont = 0;
        foreach($this->columns as $prop){
            $propertyRef = $this->refObj->getProperty($prop['name']);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            if(!empty($propertyVal)){
                $cont++;
                if($cont != 1)
                    $this->sql .= ", ";
                
                $this->sql .= $prop['column']." = ";
                if($prop['type']=='string' || $prop['type']=='date')
                    $this->sql .= "'".$propertyVal."'";
                else if($prop['type']=='int' || $prop['type']=='bool')
                    $this->sql .= $propertyVal;
                else 
                    die("Unknown data type for value ".$propertyVal." !!");
            }
        }
        if(!is_null($condition))
            $this->sql .= " WHERE ".$condition." ;";
        else
            $this->sql .= " WHERE id=".$this->getId()." ;";
        
        return $this->execQuery();
    }
    
    public function delete(){
        $this->startReflection();
        $this->sql = "DELETE FROM ".$this->table." WHERE ";
        
        $cont = 0;
        foreach($this->columns as $prop){
            $propertyRef = $this->refObj->getProperty($prop['name']);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            if(!empty($propertyVal)){
                $cont++;
                if($cont != 1)
                    $this->sql .= " AND ";
                
                $this->sql .= $prop['column']." = ";
                if($prop['type']=='string' || $prop['type']=='date')
                    $this->sql .= "'".$propertyVal."'";
                else if($prop['type']=='int' || $prop['type']=='bool')
                    $this->sql .= $propertyVal;
                else 
                    die("Unknown data type for value ".$propertyVal." !!");
            }
        }
        return $this->execQuery();
        
    }
    
    public function listAll($dir = 'ASC', $order = null){
        $this->startReflection();
        $this->sql = "SELECT * FROM ".$this->table." ";
        if(!is_null($order))
            $this->sql .= "ORDER BY ".$order." ".$dir;
        $this->sql .= ";";
        
        
        
        return $this->execQuery();
    }
    
    public function getSql() {
        return $this->sql;
    }

    public function setSql($sql) {
        $this->sql = $sql;
        return $this;
    }

    public function execQuery() {
        $this->openConnection();
        $result = mysql_query($this->sql);
        $result = $result?$result:mysql_error();
        $this->closeConnection();
        return $result;
    }

}