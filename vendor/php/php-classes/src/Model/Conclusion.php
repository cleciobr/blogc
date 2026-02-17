<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Conclusion extends Model {
  public static function getConclusions() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_conclusions");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_conclusions ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_conclusions_save(:name, :descrition, :cod_conclusion)", array(
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_conclusion"=>$this->getcod_conclusion()
    ));
    $this->setData($results[0]);
}

public function get($id_conclusion) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_conclusions WHERE id_conclusion = :id_conclusion", array(
        ":id_conclusion"=>$id_conclusion
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_conclusions_delete(:id_conclusion)", array(
        ":id_conclusion"=>$this->getid_conclusion()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_conclusionsupdate_save(:id_conclusion, :name, :descrition, :cod_conclusion)", array(
        ":id_conclusion"=>$this->getid_conclusion(),
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_conclusion"=>$this->getcod_conclusion()
    ));

    
    $this->setData($results[0]);
   
}

}
