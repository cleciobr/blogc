<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Birthday extends Model {


  /**
   * Function that return all the images_birthdays stored in database.
   */
  public static function getBirthdays()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_birthdays ORDER BY id_birthday DESC LIMIT 6");
  }

  
    //Total Birthdays actives
    public static function getBirthdaysActive()  {
      $sql = new Sql();
      $results =  $sql->select("SELECT count(*) FROM tb_birthdays WHERE birthday_active = 1");
      if (count($results) > 0) {
        return $results[0];
    }else{
        return[];
    }
  }

  //Total Birthdays actives
  public static function getListBirthdaysActive()  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_birthdays WHERE birthday_active = 1");
}

  public static function lastBirthday()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_birthdays ORDER BY id_birthday");
  }

  public static function lastBirthdayId()
  {
    $sql = new Sql();
    return $sql->select("SELECT id_birthday FROM tb_birthdays ORDER BY id_birthday");
  }


  public static function checkList($list)
  {
    foreach ($list as &$row) {
      $p = new Birthday();
      $p->setData($row);
      $row = $p->getValues();
    }
    return $list;
  }

  public static function listAll()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_birthdays ORDER BY name_birthday");
  }


  /*
        Function that stored a birthday in database
      */
  public function save()
  {
    $sql = new Sql();
    $results = $sql->select("call sp_birthdays_save(:date_birthday, :name_birthday, :esp_birthday, :department, :birthday_active)", array(
      ":date_birthday" => $this->getdate_birthday(),
      ":name_birthday" => $this->getname_birthday(),
      ":esp_birthday" => $this->getesp_birthday(),
      ":department" => $this->getdepartment(),
      ":birthday_active" => $this->getbirthday_active()
    ));

    $this->setData($results[0]);
  }


  public function get($id_birthday) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_birthdays WHERE id_birthday = :id_birthday", array(
      ":id_birthday" => $id_birthday
    ));
    
    $this->setData($results[0]);
  }

  public function delete()
  {
    $sql = new Sql();
    $sql->query("DELETE FROM tb_birthdays WHERE id_birthday = :id_birthday", [
      ":id_birthday" => $this->getid_birthday()
    ]);
  }

  public function update()
  {
    $sql = new Sql();
    $results = $sql->select("CALL sp_birthdaysupdate_save(:id_birthday, :date_birthday, :name_birthday, :esp_birthday, :department, :birthday_active)", array(
      ":id_birthday" => $this->getid_birthday(),
      ":date_birthday" => $this->getdate_birthday(),
      ":name_birthday" => $this->getname_birthday(),
      ":esp_birthday" => $this->getesp_birthday(),
      ":department" => $this->getdepartment(),
      ":birthday_active" => $this->getbirthday_active()
    ));

    $this->setData($results[0]);
  }


}
