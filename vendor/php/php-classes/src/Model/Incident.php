<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Incident extends Model {
  public static function getIncidents() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_incidents");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_incidents ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_incidents_save(:name, :descrition, :cod_incident)", array(
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_incident"=>$this->getcod_incident()
    ));
    $this->setData($results[0]);
}

public function get($id_incident) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_incidents WHERE id_incident = :id_incident", array(
        ":id_incident"=>$id_incident
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_incidents_delete(:id_incident)", array(
        ":id_incident"=>$this->getid_incident()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_incidentsupdate_save(:id_incident, :name, :descrition, :cod_incident)", array(
        ":id_incident"=>$this->getid_incident(),
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_incident"=>$this->getcod_incident()
    ));

    
    $this->setData($results[0]);
   
}

}
