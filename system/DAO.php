<?php
abstract class DAO{

    protected $connection;
    protected $selectedDB;
    private $refObj;
    private $class;
    private $properties;
    private $table;
    private $pk;
    private $columns;
    private $fieldsMap;
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
        
        $this->getTableRows();
        
        //set columns
        $cont = 0;
        foreach($this->properties as $k=>$prop){
            if($prop->class != "DAO"){
                $columnNamesArr = array();
                $refProp        = new ReflectionProperty($this->class, $prop->name);

                preg_match("/(@Columnname )(.*)/", $refProp->getDocComment(), $columnNamesArr);
                
                foreach ($this->columns as $id => $column) {
                    if($column['name'] == $prop->name || (isset($columnNamesArr[0]) && $column['name'] == $columnNamesArr[2]))
                        $this->fieldsMap[$prop->name] = $id;
                }
                
                $cont++;
            }
            else{
                unset($this->properties[$k]);
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
        foreach($this->properties as $prop){
            $propertyRef = $this->refObj->getProperty($prop->name);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            if(!empty($propertyVal)){
                $cont++;
                if($cont != 1)
                    $this->sql .= ",";
                
                $column = $this->columns[$this->fieldsMap[$prop->name]];
                
                
                $values[$cont]['val']      = $propertyVal;
                $values[$cont]['type']     = $column['type'];
                $this->sql .= $column['name'];

            }
        }
        $this->sql .= ") VALUES(";
        $cont = 0;
        foreach($values as $value){
            $cont++;
            if($cont != 1)
                $this->sql .= ",";
            if(strstr($value['type'],'varchar') || strstr($value['type'], 'date'))
                $this->sql .= "'".$value['val']."'";
            else if(strstr($value['type'], 'int') || strstr($value['type'], 'bool'))
                $this->sql .= $value['val'];
            else 
                die("Unknown data type for value ".$value['val']." !!");
               
        }
        $this->sql .= ");";
        
        return $this->execQuery();

    }
    
    public function update($condition = null){
        $this->startReflection();
        $this->sql  = "UPDATE ".$this->table." SET ";

        $cont = 0;
        foreach($this->properties as $prop){
            $propertyRef = $this->refObj->getProperty($prop->name);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            if(!empty($propertyVal)){
                $cont++;
                if($cont != 1)
                    $this->sql .= ",";
                
                $column = $this->columns[$this->fieldsMap[$prop->name]];
                
                $this->sql .= $column['name']." = ";
                if(strstr($column['type'],'varchar') || strstr($column['type'],'date'))
                    $this->sql .= "'".$propertyVal."'";
                else if(strstr($column['type'],'int') || strstr($column['type'],'bool'))
                    $this->sql .= $propertyVal;
                else
                    die("Unknown data type for value ".$propertyVal." !!");

            }
        }

        if(is_null($condition)){
            $propertyRef = $this->refObj->getProperty($this->pk);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            $condition = $this->pk." = ".$propertyVal;
        }
        $this->sql .= " WHERE ".$condition." ;";

        return $this->execQuery();
    }
    
    public function delete($condition = null){
        $this->startReflection();
        
        if(is_null($condition)){
            $propertyRef = $this->refObj->getProperty($this->pk);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            $condition = $this->pk." = ".$propertyVal;
        }
        
        $this->sql = "DELETE FROM ".$this->table." WHERE ".$condition;
        return $this->execQuery();
        
    }
    
    public function listAll($dir = 'ASC', $order = null, $pag = null, $perpag = null){
        $this->startReflection();
        $this->sql = "SELECT * FROM ".$this->table." ";
        
        if(!is_null($pag) && !is_null($perpag)){
            $ini =  $perpag * ($pag-1);
            if(!is_null($order))
                $this->sql .= "ORDER BY ".$order." ".$dir." LIMIT ".$ini.",".$perpag;
            else
                $this->sql .= "ORDER BY ".$this->pk." ".$dir." LIMIT ".$ini.",".$perpag;
        }else if(!is_null($order)){
            $this->sql .= "ORDER BY ".$order." ".$dir;
        }
        
            
        $this->sql .= ";";
  
        return $this->createArrayResults($this->execQuery());
    }
    
    public function getNumRows(){
        $this->startReflection();
        $this->sql = "SELECT count(*) FROM ".$this->table.";";
        $rs = $this->execQuery();
        $row = mysql_fetch_row($rs);
        return $row[0];
    }
    
    private function getTableRows(){
        $this->sql = "SHOW COLUMNS FROM ".$this->table.";";
        $result = $this->execQuery();
        if (!$result) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if (mysql_num_rows($result) > 0) {
            $count = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $this->columns[$count] = array( 'name' => $row['Field'],
                                                'type' => $row['Type']);
                if($row['Key'] == 'PRI'){
                    $this->pk = $row['Field'];
                }
                $count++;
            }
        }

    }
    
    public function load(){
        $this->startReflection();
        $propertyRef = $this->refObj->getProperty($this->pk);
        $propertyRef->setAccessible(true);
        $propertyVal = $propertyRef->getValue($this);
        $this->sql = "SELECT * FROM ".$this->table." WHERE ".$this->pk." = ".$propertyVal.";";
        $result = $this->execQuery();

        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                foreach ($row as $nameC => $valueC) {
                    foreach($this->columns as $k => $v){
                        if($nameC==$v['name']){
                            $map = array_flip($this->fieldsMap);
                            $f = "set".ucfirst($map[$k]);
                            $this->$f($valueC);
                        }
                    }
                }
            }
        }
        
    }
    
    public function search(){
        $this->startReflection();
        $this->sql = "SELECT * FROM ".$this->table." WHERE ";
        
        $cont = 0;
        foreach($this->properties as $prop){
            $propertyRef = $this->refObj->getProperty($prop->name);
            $propertyRef->setAccessible(true);
            $propertyVal = $propertyRef->getValue($this);
            if(!empty($propertyVal)){
                $cont++;
                if($cont != 1)
                    $this->sql .= ",";
                
                $column = $this->columns[$this->fieldsMap[$prop->name]];
                
                $this->sql .= $column['name']." = ";
                if(strstr($column['type'],'varchar') || strstr($column['type'],'date'))
                    $this->sql .= "'".$propertyVal."'";
                else if(strstr($column['type'],'int') || strstr($column['type'],'bool'))
                    $this->sql .= $propertyVal;
                else
                    die("Unknown data type for value ".$propertyVal." !!");

            }
        }
            
        $this->sql .= ";";
  
        return $this->createArrayResults($this->execQuery());
    }
    
    /**
    * @TODO verify the access way for this attibutes, it's strange.
    */
    protected function createArrayResults($rs){
        while ($row = mysql_fetch_assoc($rs)) {
            $obj = new stdClass();
            foreach ($row as $nameC => $valueC) {
                foreach($this->columns as $k => $v){
                    if($nameC==$v['name']){
                        $map = array_flip($this->fieldsMap);
                        $f = $map[$k];
                        $obj->$f = $valueC;
                    }
                }
            }
            $arr[] = $obj;
        }
        
        return $arr;
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