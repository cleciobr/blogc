<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Class_occ extends Model {
  public static function getClass_occs() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_class_occs");
  }
}
