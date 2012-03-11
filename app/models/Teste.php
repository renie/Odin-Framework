<?php
/**
 * @Tablename teste_dao
 */
class Teste extends DAO{
    
    /**
     * @Columntype int
     */
    private $id;
    
    /**
     * @Columnname thename
     */
    private $name;
    
    /**
     * @Columntype bool
     */
    private $xpto;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getXpto() {
        return $this->xpto;
    }

    public function setXpto($xpto) {
        $this->xpto = $xpto;
        return $this;
    }


}

?>
