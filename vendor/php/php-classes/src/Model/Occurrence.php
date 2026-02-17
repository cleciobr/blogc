<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Occurrence extends Model {
  public static function getOccurrences() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_occurrences");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_occurrences ORDER BY name");
}


public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_occurrences_save(:name, :days_occurrence, :descrition, :cod_occurrence)", array(
        ":name"=>$this->getname(),
        ":days_occurrence"=>$this->getdays_occurrence(),
        ":descrition"=>$this->getdescrition(),
        ":cod_occurrence"=>$this->getcod_occurrence()
    ));
    $this->setData($results[0]);
}


public function get($id_occurrence) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_occurrences WHERE id_occurrence = :id_occurrence", array(
        ":id_occurrence"=>$id_occurrence
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_occurrences_delete(:id_occurrence)", array(
        ":id_occurrence"=>$this->getid_occurrence()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_occurrencesupdate_save(:id_occurrence, :name, :days_occurrence, :descrition, :cod_occurrence)", array(
        ":id_occurrence"=>$this->getid_occurrence(),
        ":name"=>$this->getname(),
        ":days_occurrence"=>$this->getdays_occurrence(),
        ":descrition"=>$this->getdescrition(),
        ":cod_occurrence"=>$this->getcod_occurrence()
    ));
    
    $this->setData($results[0]);
   
}

    public static function setSuccess($msg) {
        update()[Occorrence::SUCCESS] = $msg;
    }

}
