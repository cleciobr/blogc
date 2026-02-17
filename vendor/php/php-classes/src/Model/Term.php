<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Term extends Model {
  public static function getTerms() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_terms");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_terms ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_terms_save(:name, :days_term, :descrition, :cod_term)", array(
        ":name"=>$this->getname(),
        ":days_term"=>$this->getdays_term(),
        ":descrition"=>$this->getdescrition(),
        ":cod_term"=>$this->getcod_term()
    ));
    $this->setData($results[0]);
}

public function get($id_term) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_terms WHERE id_term = :id_term", array(
        ":id_term"=>$id_term
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_terms_delete(:id_term)", array(
        ":id_term"=>$this->getid_term()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_termsupdate_save(:id_term, :name, :days_term, :descrition, :cod_term)", array(
        ":id_term"=>$this->getid_term(),
        ":name"=>$this->getname(),
        ":days_term"=>$this->getdays_term(),
        ":descrition"=>$this->getdescrition(),
        ":cod_term"=>$this->getcod_term()
    ));

    
    $this->setData($results[0]);
   
}

}
