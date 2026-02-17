<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Popup extends Model
{

  /**
   * Function that return all the images_popups stored in database.
   */
  public static function getPopups()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_popups ORDER BY id_popup DESC LIMIT 6");
  }

  /**
   * Function that return the last image_popup stored in database.
   */
  public static function getLast2Popups()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_popups ORDER BY id_popup DESC LIMIT 3");
  }

  /**
   *  
   */
  public static function checkList($list)
  {
    foreach ($list as &$row) {
      $p = new Popup();
      $p->setData($row);
      $row = $p->getValues();
    }
    return $list;
  }

  /**
   * 
   */
  public function get($id_popup)
  {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_popups WHERE id_popup = :id_popup", array(
      ":id_popup" => $id_popup
    ));
    $this->setData($results[0]);
  }

  /**
   * Function that stored a image_popup in database
   */
  public function save()
  {
    $sql = new Sql();
    $results = $sql->select("CALL sp_popups_save(:id_popup, :popup_title, :popup_active, :id_user)", array(
      ":id_popup" => $this->getid_popup(),
      ":popup_title" => $this->getpopup_title(),
      ":popup_active" => $this->getpopup_active(),
      ":id_user" => $this->getid_user()
    ));
    $this->setData($results[0]);
  }

  /**
   * Function that delete one image_popup stored in database
   */
  public function delete()
  {
    $sql = new Sql();
    $sql->query("DELETE FROM tb_popups WHERE id_popup = :id_popup", [
      ":id_popup" => $this->getid_popup()
    ]);
  }

  /**
   * Function that check if the Photo exists in popups folder 
   */
  public function checkPhoto()
  {
    if (file_exists($_SERVER['DOCUMENT_ROOT']
      . DIRECTORY_SEPARATOR . "res"
      . DIRECTORY_SEPARATOR . "site"
      . DIRECTORY_SEPARATOR . "img"
      . DIRECTORY_SEPARATOR . "popups"
      . DIRECTORY_SEPARATOR . $this->getid_popup() . ".jpg")) {
      $url = "/res/site/img/popups/" . $this->getid_popup() . ".jpg";
    } else {
      $url = "/res/site/img/popup.jpg";
    }
    return $this->setdesphoto($url);
  }

  /**
   * Function that return the values of the function checkphoto in the server
   */
  public function getValues()
  {
    $this->checkPhoto();
    $values = parent::getValues();
    return $values;
  }

  /**
   * Function that store a photo in popups folder
   */
  public function setPhotos($file)
  {
    $extension = explode('.', $file['name']);
    $extension = end($extension);
    switch ($extension) {
      case 'jpg':
      case 'jpeg':
        $image = imagecreatefromjpeg($file['tmp_name']);
        break;

      case 'gif':
        $image = imagecreatefromgif($file['tmp_name']);
        break;

      case 'png':
        $image = imagecreatefrompng($file['tmp_name']);
        break;
    }
    $dist = $_SERVER['DOCUMENT_ROOT']
      . DIRECTORY_SEPARATOR . "res"
      . DIRECTORY_SEPARATOR . "site"
      . DIRECTORY_SEPARATOR . "img"
      . DIRECTORY_SEPARATOR . "popups"
      . DIRECTORY_SEPARATOR . $this->getid_popup() . ".jpg";
    imagejpeg($image, $dist);
    imagedestroy($image);
    $this->checkPhoto();
  }
}
