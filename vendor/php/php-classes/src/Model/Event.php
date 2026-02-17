<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Event extends Model {

  public static function listAll()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_events");
  }

  public static function lastEvent()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_events ORDER BY id_event DESC LIMIT 1");
  }

  public static function lastEventId()
  {
    $sql = new Sql();
    return $sql->select("SELECT id_event FROM tb_events ORDER BY id_event DESC LIMIT 1");
  }


   public function save(){
     $eventTitle = $this->getname_event();
     $slugTitle = $this->slugify($eventTitle);
     $sql = new Sql();
     $results = $sql->select("CALL sp_events_save(:id_event, :name_event, :descripition_event, :url_slug, :id_user)", array(
      ":id_event" => $this->getid_event(),
       ":name_event"=>$this->getname_event(),
       ":descripition_event"=>$this->getdescription_event(),
       ":url_slug"=>$slugTitle,
       ":id_user"=>$this->getid_user()

      ));
         $this->setData($results[0]);
    }

  // public function saves()
  // {
  //   $eventTitle = $this->getname_event();
  //   $slugTitle = $this->slugify($eventTitle);

  //   $sql = new Sql();
  //   $results = $sql->select("CALL sp_events_save(:id_event, :name_event, :description_event, :url_slug, :id_user)", [
  //     ":id_event" => $this->getid_event(),
  //     ":name_event" => $this->getname_event(),
  //     ":description_event" => $this->getdescription_event(),
  //     ":url_slug" => $slugTitle,
  //     ":id_user" => $this->getid_user()
  //   ]);
  //   $this->setData($results[0]);
  // }

  public function getSixPhotos()
  {
    $sql = new Sql();
    $resultsExistPhotos = $sql->select("SELECT * FROM tb_photos WHERE id_event = :id_event LIMIT 6", [":id_event" => $this->getid_event()]);

    $countResultsPhotos = count($resultsExistPhotos);

    if ($countResultsPhotos > 0) {
      foreach ($resultsExistPhotos as &$result) {
        foreach ($result as $key => $value) {
          if ($key === "name_photo") {
            $result["desphoto"] = "/res/site/img/events/" . $result["name_photo"];
          }
        }
      }
      return $resultsExistPhotos;
    }
  }

  public static function checkList($list)
  {
    foreach ($list as &$row) {
      $p = new Event();
      $p->setData($row);
      $row =  $p->getValues();
    }
    return $list;
  }

  // public function save_old() {
  //   $eventTitle = $this->getname_event();
  //   $slugTitle = $this->slugify($eventTitle);
  //   $sql = new Sql();
  //   $results = $sql->select("CALL sp_events_save(:name_event, :description_event, :url_slug, :id_user)", array(
  //     ":name_event"=>$this->getname_event(),
  //     ":description_event"=>$this->getdescription_event(),
  //     ":url_slug"=>$slugTitle,
  //     ":id_user"=>$this->getid_user()
  //   ));

  //   $this -> setData($results[0]);
  // }


  public function update()
  {
    $eventTitle = $this->getname_event();
    $slugTitle = $this->slugify($eventTitle);

    $sql = new Sql();
    $results = $sql->select("CALL sp_eventsupdate_save(:id_event, :name_event, :description_event, :url_slug, :id_user)", array(
      ":id_event" => $this->getid_event(),
      ":name_event" => $this->getname_event(),
      ":description_event" => $this->getdescription_event(),
      ":url_slug" => $slugTitle,
      ":id_user" => $this->getid_user()
    ));

    $this->setData($results[0]);
  }


  public function slugify($text)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }

  public function get($id_event)
  {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_events WHERE id_event = :id_event", [
      "id_event" => $id_event
    ]);
    $this->setData($results[0]);
  }

//  public function delete(){
//     $sql = new Sql();

//     // 1. Busca os nomes das fotos usando a coluna CORRETA: name_photo
//     $photos = $sql->select("SELECT name_photo FROM tb_photos WHERE id_event = :id_event", [
//         ":id_event" => $this->getid_event()
//     ]);

//     // 2. Loop para remover os arquivos físicos
//     foreach ($photos as $photo) {
//         // Monta o caminho exatamente como você fez no deletePhoto que funciona
//         $filePath = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/events/" . $photo['name_photo'];
        
//         if (file_exists($filePath) && !is_dir($filePath)) {
//             unlink($filePath);
//         }
//     }

//     // 3. Deleta todos os registros de fotos deste evento no banco
//     $sql->query("DELETE FROM tb_photos WHERE id_event = :id_event", [
//         ":id_event" => $this->getid_event()
//     ]);

//     // 4. Deleta o evento principal
//     $sql->query("DELETE FROM tb_events WHERE id_event = :id_event", [
//         ":id_event" => $this->getid_event()
//     ]);
// }

public function delete(){
    $sql = new Sql();

    $photos = $sql->select("SELECT name_photo FROM tb_photos WHERE id_event = :id_event", [
        ":id_event" => $this->getid_event()
    ]);

    foreach ($photos as $photo) {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "events" . DIRECTORY_SEPARATOR . $photo['name_photo'];
        
        if (file_exists($filePath) && !is_dir($filePath)) {
            unlink($filePath);
        }
    }

    $sql->query("DELETE FROM tb_photos WHERE id_event = :id_event", [
        ":id_event" => $this->getid_event()
    ]);

    $sql->query("DELETE FROM tb_events WHERE id_event = :id_event", [
        ":id_event" => $this->getid_event()
    ]);
}



  public function getValues()
  {
    $this->checkPhoto();
    $values = parent::getValues();
    return $values;
  }


  // public function setPhotos($files, $id_event){

  //   $files = $_FILES["files"];
  //   $numFile = count(array_filter($files["name"]));

  //   if ($numFile > 0) {
  //     $sql = new Sql();
  //     $resultsExistPhotos = $sql->select("SELECT * FROM tb_photos WHERE id_event = :id_event", [
  //       ":id_event" => $id_event
  //     ]);

  //     $timeStampNow = time();
  //     $countResultsPhotos = count($resultsExistPhotos);

  //     for ($i = 0; $i < $countResultsPhotos; $i++) {
  //       if ($timeStampNow > $resultsExistPhotos[$i]["dt_photo"]) {
  //         $filename = $_SERVER["DOCUMENT_ROOT"] .
  //           DIRECTORY_SEPARATOR . "res" .
  //           DIRECTORY_SEPARATOR . "site" .
  //           DIRECTORY_SEPARATOR . "img" .
  //           DIRECTORY_SEPARATOR . "events" .
  //           DIRECTORY_SEPARATOR . $resultsExistPhotos[$i]["id_event"] . "-" .
  //           $resultsExistPhotos[$i]["id_photo"] . ".jpg";

  //         $resultsDeletedPhotos = $sql->query("DELETE FROM tb_photos WHERE id_event = :id_event", [
  //           "id_event" => $resultsExistPhotos[$i]["id_event"]
  //         ]);
  //       }
  //     }


  //     for ($i = 0; $i <= $numFile; $i++) {
  //       if (isset($files["name"][$i])) {
  //         $name = $files["name"][$i];

  //         $extension = explode(".", $name);
  //         $extension = end($extension);

  //         switch ($extension) {
  //           case 'jpg':
  //           case 'jpeg':
  //             $image = imagecreatefromjpeg($files["tmp_name"][$i]);
  //             break;

  //           case 'gif':
  //             $image = imagecreatefromgif($files["tmp_name"][$i]);
  //             break;

  //           case 'png':
  //             $image = imagecreatefrompng($files["tmp_name"][$i]);
  //             break;
  //         }

  //         $countImg = $i + 1;
  //         $namePhoto = $this->getid_event() . "-" . $countImg . ".jpg";

  //         $dist = $_SERVER["DOCUMENT_ROOT"].
  //           DIRECTORY_SEPARATOR . "res" .
  //           DIRECTORY_SEPARATOR . "site" .
  //           DIRECTORY_SEPARATOR . "img" .
  //           DIRECTORY_SEPARATOR . "events" .
  //           DIRECTORY_SEPARATOR . $namePhoto;

  //         imagejpeg($image, $dist);
  //         imagedestroy($image);

  //         $sql->query("INSERT INTO tb_photos (id_photo, name_photo, id_event) VALUES (:id_photo, :name_photo, :id_event)", [
  //           ":id_photo" => $this->getid_photo(),
  //           ":name_photo" => $namePhoto,
  //           ":id_event" => $this->getid_event()
  //         ]);

  //         $this->getPhotos();
  //       }
  //     }
  //   }
  // }

//   public function setPhotos($files, $id_event) {

//     $fileNames = array_filter($files["name"]);
//     $numFile = count($fileNames);

//     if ($numFile > 0) {
//         $sql = new Sql();

//         // 2. Loop para salvar cada arquivo
//         // Use foreach para evitar erros de índice pulado
//         foreach ($files["tmp_name"] as $key => $tmpName) {
            
//             if (empty($tmpName)) continue;

//             $name = $files["name"][$key];
//             $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

//             // Cria o recurso da imagem conforme o tipo
//             switch ($extension) {
//                 case 'jpg':
//                 case 'jpeg': $image = @imagecreatefromjpeg($tmpName); break;
//                 case 'gif':  $image = @imagecreatefromgif($tmpName); break;
//                 case 'png':  $image = @imagecreatefrompng($tmpName); break;
//                 default: $image = false; break;
//             }

//             if ($image) {
//                 // Gera um nome único para evitar sobrescrever fotos de eventos diferentes
//                 // Sugestão: idDoEvento-timestamp-indice
//                 $namePhoto = $id_event . "-" . time() . "-" . $key . ".jpg";

//                 $dist = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 
//                         "res" . DIRECTORY_SEPARATOR . 
//                         "site" . DIRECTORY_SEPARATOR . 
//                         "img" . DIRECTORY_SEPARATOR . 
//                         "events" . DIRECTORY_SEPARATOR . $namePhoto;

//                 // Salva a imagem como JPG
//                 if (imagejpeg($image, $dist, 80)) {
//                     imagedestroy($image);

//                     // 3. INSERT - Removido o id_photo para o banco gerar sozinho
//                     $sql->query("INSERT INTO tb_photos (name_photo, id_event) VALUES (:name_photo, :id_event)", [
//                         ":name_photo" => $namePhoto,
//                         ":id_event" => $id_event
//                     ]);
//                 }
//             }
//         }
//     }
// }


public function setPhotos($files, $id_event) {
    $fileNames = array_filter($files["name"]);
    
    if (count($fileNames) > 0) {
        $sql = new Sql();
        $i = 1; 

        foreach ($files["tmp_name"] as $key => $tmpName) {
            if (empty($tmpName)) continue;

            // LÊ O CONTEÚDO DO ARQUIVO (Independente se é .jfif, .png, .webp, etc)
            $data = file_get_contents($tmpName);
            
            $image = @imagecreatefromstring($data);

            if ($image !== false) {
                
                // Define o nome padrão sempre como .jpg
                $namePhoto = $id_event . "-" . $i . ".jpg";

                $dist = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "res" . 
                        DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . 
                        DIRECTORY_SEPARATOR . "events" . DIRECTORY_SEPARATOR . $namePhoto;

                if (imagejpeg($image, $dist, 80)) { //máximo 100
                    imagedestroy($image);

                    $sql->query("INSERT INTO tb_photos (name_photo, id_event) VALUES (:name_photo, :id_event)", [
                        ":name_photo" => $namePhoto,
                        ":id_event" => $id_event
                    ]);
                    
                    $i++; 
                }
            }
        }
    }
}




public function deletePhoto($id_photo){
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_photos WHERE id_photo = :id_photo", [
        ':id_photo' => $id_photo
    ]);

    if (count($results) > 0) {
        $photoData = $results[0]; 
        
        $filePath = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/events/" . $photoData['name_photo']; 
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Excluir o registro da imagem no banco de dados
        $sql->query("DELETE FROM tb_photos WHERE id_photo = :id_photo", [
            ':id_photo' => $id_photo
        ]);
    }
}

  public function getPhotos()
  {
    $sql = new Sql();
    $resultsExistPhotos = $sql->select("SELECT * FROM tb_photos WHERE id_event = :id_event", [
      ":id_event" => $this->getid_event()
    ]);

    $countResultsPhotos = count($resultsExistPhotos);

    if ($countResultsPhotos > 0) {
      foreach ($resultsExistPhotos as &$result) {
        foreach ($result as $key => $value) {
          if ($key === "name_photo") {
            $result["desphoto"] = "/res/site/img/events/" . $result["name_photo"];
          }
        }
      }

      return $resultsExistPhotos;
    }
  }

  public function getFirstPhoto()
  {
    return $url = "/res/site/img/events" . $this->getid_event() . "-" . 1 . ".jpg";
  }

  public function getEventsPage($page = 1, $itemsPerPage = 12)
  {
    $start = ($page - 1) * $itemsPerPage;
    $sql = new Sql();
    $results = $sql->select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_events ORDER BY id_event DESC LIMIT $start, $itemsPerPage");
    $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");
    return [
      'data' => Event::checkList($results),
      'total' => (int)$resultTotal[0]["nrtotal"],
      'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage),
    ];
  }

  public function getFromURL($id_event, $url_slug)
  {
    $sql = new Sql();
    $rows = $sql->select("SELECT * FROM tb_events WHERE id_event = :id_event AND url_slug = :url_slug", [
      ':id_event' => $id_event,
      ':url_slug' => $url_slug
    ]);
    if (count($rows) > 0) {
      return $this->setData($rows[0]);
    } else {
      header("Location: /events");
      exit;
    }
  }
}
