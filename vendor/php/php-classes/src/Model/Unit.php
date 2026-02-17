<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Unit extends Model {
  public static function getUnits() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_units");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_units ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_units_save(:name, :cod_unit)", array(
        ":name"=>$this->getname(),
        ":cod_unit"=>$this->getcod_unit()
    ));
    $this->setData($results[0]);
}

public function get($id_unit) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_units WHERE id_unit = :id_unit", array(
        ":id_unit"=>$id_unit
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_units_delete(:id_unit)", array(
        ":id_unit"=>$this->getid_unit()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_unitsupdate_save(:id_unit, :name, :cod_unit)", array(
        ":id_unit"=>$this->getid_unit(),
        ":name"=>$this->getname(),
        ":cod_unit"=>$this->getcod_unit()
    ));

    
    $this->setData($results[0]);
   
}

}
