<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Internacionalsecurity extends Model {
  public static function getInternacionalsecuritys() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_internacionalsecuritys");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_internacionalsecuritys ORDER BY name");
}


public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_internacionalsecuritys_save(:name, :descrition, :cod_internacionalsecurity)", array(
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_internacionalsecurity"=>$this->getcod_internacionalsecurity()
    ));
    $this->setData($results[0]);
}


public function get($id_internacionalsecurity) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_internacionalsecuritys WHERE id_internacionalsecurity = :id_internacionalsecurity", array(
        ":id_internacionalsecurity"=>$id_internacionalsecurity
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_internacionalsecuritys_delete(:id_internacionalsecurity)", array(
        ":id_internacionalsecurity"=>$this->getid_internacionalsecurity()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_internacionalsecuritysupdate_save(:id_internacionalsecurity, :name,  :descrition, :cod_internacionalsecurity)", array(
        ":id_internacionalsecurity"=>$this->getid_internacionalsecurity(),
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_internacionalsecurity"=>$this->getcod_internacionalsecurity()
    ));
    
    $this->setData($results[0]);
   
}

    public static function setSuccess($msg) {
        update()[Occorrence::SUCCESS] = $msg;
    }

}
