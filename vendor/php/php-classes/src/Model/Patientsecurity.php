<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Patientsecurity extends Model {
  public static function getPatientsecuritys() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_patientsecuritys");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_patientsecuritys ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_patientsecuritys_save(:name, :descrition, :cod_patientsecurity)", array(
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_patientsecurity"=>$this->getcod_patientsecurity()
    ));
    $this->setData($results[0]);
}

public function get($id_patientsecurity) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_patientsecuritys WHERE id_patientsecurity = :id_patientsecurity", array(
        ":id_patientsecurity"=>$id_patientsecurity
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_patientsecuritys_delete(:id_patientsecurity)", array(
        ":id_patientsecurity"=>$this->getid_patientsecurity()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_patientsecuritysupdate_save(:id_patientsecurity, :name, :descrition, :cod_patientsecurity)", array(
        ":id_patientsecurity"=>$this->getid_patientsecurity(),
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_patientsecurity"=>$this->getcod_patientsecurity()
    ));

    
    $this->setData($results[0]);
   
}

}
