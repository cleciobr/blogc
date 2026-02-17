<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Birthday extends Model {


public static function listAll(){
    $sql = new Sql();
    // O SQL abaixo compara a coluna date_birthday com a data atual (dia/mês)
    return $sql->select("
        SELECT *, 
        CASE 
            WHEN date_birthday = DATE_FORMAT(NOW(), '%d/%m') THEN 1 
            ELSE 0 
        END AS birthday_active 
        FROM tb_birthdays 
        ORDER BY name_birthday
    ");
}

   public static function listAll2()
   {
     $sql = new Sql();
     return $sql->select("SELECT * FROM tb_birthdays ORDER BY name_birthday");
   }


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



  /*
        Function that stored a birthday in database
      */
public function save()
{
    $sql = new Sql();
    // Adicionado o 6º parâmetro: :email_recipient
    $results = $sql->select("call sp_birthdays_save(:date_birthday, :name_birthday, :esp_birthday, :department, :birthday_active, :email_recipient)", array(
      ":date_birthday"   => $this->getdate_birthday(),
      ":name_birthday"   => $this->getname_birthday(),
      ":esp_birthday"    => $this->getesp_birthday(),
      ":department"      => $this->getdepartment(),
      ":birthday_active" => $this->getbirthday_active(),
      ":email_recipient" => $this->getemail_recipient()
    ));

    if (isset($results[0])) {
        $this->setData($results[0]);
    }
}


  public function sendBirthdayEmail($id_birthday, $nome, $emailDestino) {
      $mailer = new \Php\MailerBirthday(
          $id_birthday, 
          $_POST['date_birthday'], 
          $_POST['name_birthday'],
          $_POST['esp_birthday'],
          $_POST['department'],
          // "Aniversariante do Dia: " . $_POST['name_birthday'],
          " " . $_POST['name_birthday'],
          "sendbirthday",
          $emailDestino,
          array(
              "id" => $id_birthday,
              "nome" => $_POST['name_birthday'],
              "data_nasc" => $_POST['date_birthday'],
              "funcao" => $_POST['esp_birthday'],
              "setor" => $_POST['department']
          )
      );

      $enviado = $mailer->send();

      if (!$enviado) {
          error_log("Erro ao enviar e-mail de aniversário para o ID: " . $id_birthday);
      }
      
      return $enviado; 
  }





  public function get($id_birthday) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_birthdays WHERE id_birthday = :id_birthday", array(
      ":id_birthday" => $id_birthday
    ));
    
    $this->setData($results[0]);
  }

  // public function delete()
  // {
  //   $sql = new Sql();
  //   $sql->query("DELETE FROM tb_birthdays WHERE id_birthday = :id_birthday", [
  //     ":id_birthday" => $this->getid_birthday()
  //   ]);
  // }


 public function delete() {
    $pasta = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "aniver" . DIRECTORY_SEPARATOR;
    
    // Busca e deleta qualquer arquivo que comece com o ID e tenha sublinhado (ID_0, ID_1...)
    $arquivos = glob($pasta . $this->getid_birthday() . "_*.*");
    
    if ($arquivos) {
        foreach ($arquivos as $arquivo) {
            if (file_exists($arquivo)) {
                unlink($arquivo);
            }
        }
    }

    $sql = new \Php\DB\Sql();
    $sql->query("DELETE FROM tb_birthdays WHERE id_birthday = :id", [
        ":id" => $this->getid_birthday()
    ]);
}

  // public function update()
  // {
  //   $sql = new Sql();
  //   $results = $sql->select("CALL sp_birthdaysupdate_save(:id_birthday, :date_birthday, :name_birthday, :esp_birthday, :department, :birthday_active)", array(
  //     ":id_birthday" => $this->getid_birthday(),
  //     ":date_birthday" => $this->getdate_birthday(),
  //     ":name_birthday" => $this->getname_birthday(),
  //     ":esp_birthday" => $this->getesp_birthday(),
  //     ":department" => $this->getdepartment(),
  //     ":birthday_active" => $this->getbirthday_active()
  //   ));

  //   $this->setData($results[0]);
  // }

public function update()
  {
    $sql = new Sql();
    $results = $sql->select("CALL sp_birthdaysupdate_save(:id_birthday, :date_birthday, :name_birthday, :esp_birthday, :department, :birthday_active, :id_user)", array(
      ":id_birthday" => $this->getid_birthday(),
      ":date_birthday" => $this->getdate_birthday(),
      ":name_birthday" => $this->getname_birthday(),
      ":esp_birthday" => $this->getesp_birthday(),
      ":department" => $this->getdepartment(),
      ":birthday_active" => $this->getbirthday_active(),
      ":id_user"         => getUserId()
    ));

    $this->setData($results[0]);
  }

//Uma fotos
//   public function setPhoto($file) {
//     // Garante que pegamos apenas o primeiro arquivo, mesmo que venha em array
//     $name = is_array($file['name']) ? $file['name'][0] : $file['name'];
//     $tmpName = is_array($file['tmp_name']) ? $file['tmp_name'][0] : $file['tmp_name'];

//     if (!$tmpName) return;

//     $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

//     switch ($extension) {
//         case 'jpg': case 'jpeg': $image = imagecreatefromjpeg($tmpName); break;
//         case 'gif': $image = imagecreatefromgif($tmpName); break;
//         case 'png': $image = imagecreatefrompng($tmpName); break;
//         default: return; 
//     }

//     $pasta = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/aniver/";
    
//     // Limpa fotos antigas (png, jpg, etc) antes de criar a nova .jpg
//     array_map('unlink', glob($pasta . $this->getid_birthday() . ".*"));

//     if ($image) {
//         imagejpeg($image, $pasta . $this->getid_birthday() . ".jpg", 90);
//         imagedestroy($image);
//     }
// }
public static function listAllWithPhotos() {
    $sql = new \Php\DB\Sql();
    $data = $sql->select("SELECT * FROM tb_birthdays ORDER BY name_birthday");

    if (!$data) return [];

    foreach ($data as &$row) {
        $row['html_photos'] = ''; // Inicializa sempre vazio para evitar erro de índice
        $id = $row['id_birthday'];
        $pasta = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/aniver/";
            
        // Busca jpg, png ou jpeg (maiúsculo ou minúsculo)
        $files = glob($pasta . $id . "_*.{jpg,jpeg,png,JPG,JPEG,PNG}", GLOB_BRACE);
        
        $html = "";
        if ($files) {
            foreach ($files as $file) {
                // Converte caminho do Windows para URL da Web
                $src = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
                $src = str_replace('\\', '/', $src); 
                
                $html .= '<img src="'.$src.'" style="width:40px; height:40px; object-fit:cover; border-radius:4px; border:1px solid #ddd; margin-right:5px; margin-bottom:5px;">';
            }
        } else {
            $html = '<span class="text-muted" style="font-size: 10px;">Sem fotos</span>';
        }
        
        $row['html_photos'] = $html;
    }

    return $data;
}


public function getPhotos() {
    $pasta = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/aniver/";
    $files = glob($pasta . $this->getid_birthday() . "_*.jpg");
    $photoList = [];
    
    foreach ($files as $index => $file) {
        $photoList[] = [
            'id_photo' => $index, 
            'desphoto' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $file), 
            'filename' => basename($file) 
        ];
    }
    return $photoList;
}

public function deleteSelectedPhotos($filenames) {
    $pasta = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/aniver/";
    // Transforma a string "foto1.jpg,foto2.jpg" em array
    $files = explode(',', $filenames);
    
    foreach ($files as $file) {
        if (!empty($file)) {
            $path = $pasta . basename($file); // basename por segurança
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
//Multipla fotos
public function setPhotos($files) {
    $pasta = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/aniver/";
    
    // IMPORTANTE: Remova o unlink global para não apagar tudo no update
    // array_map('unlink', glob($pasta . $this->getid_birthday() . "_*.*"));

    foreach ($files['name'] as $key => $name) {
        if ($files['error'][$key] === 0) {
            $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $tmpName = $files['tmp_name'][$key];
            $image = null; 

            switch ($extension) {
                case 'jpg': case 'jpeg': $image = imagecreatefromjpeg($tmpName); break;
                case 'png':  $image = imagecreatefrompng($tmpName); break;
                case 'gif':  $image = imagecreatefromgif($tmpName); break;
                case 'webp': 
                    if (function_exists('imagecreatefromwebp')) {
                        $image = imagecreatefromwebp($tmpName);
                    }
                    break;
            }
            if ($image) {
                // Usa ID + Timestamp + Chave para o nome ser único e não sobrescrever
                $fileName = $this->getid_birthday() . "_" . time() . "_" . $key . ".jpg";
                $dist = $pasta . $fileName;
                
                imagejpeg($image, $dist, 80);
                imagedestroy($image);
            }
        }
    }
}

}


