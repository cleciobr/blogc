<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Subscription extends Model {



public static function listAll() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_subscriptions");
    }

    public static function listAllLimit() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_subscriptions ORDER BY id_subscription DESC LIMIT 8");
    }

    public static function listSubscription() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_subscriptions");
    }

    public static function checkList($list) {
        foreach ($list as &$row) {
            $p = new Subscription();
			$p->setData($row);
			$row = $p->getValues();
        }
        return $list;
    }


    public function save() {
        $subscriptionName = $this->getname();
        $slugTitle = $this->slugify($subscriptionName);
        $sql = new Sql();
        $results = $sql->select("CALL sp_subscriptions_save(:cod_subscription, :name, :name_color, :description, :url_slug, :subscription_active, :id_user)", array(
            ":cod_subscription"=>$this->getcod_subscription(),
            ":name"=>$this->getname(),
            ":name_color"=>$this->getname_color(),
            ":description"=>$this->getdescription(),
	        ":url_slug"=>$slugTitle,
            ":subscription_active" => $this -> getsubscription_active(),
            ":id_user"=>$this->getid_user()
        ));
        
        $this->setData($results[0]);
    }
   
    public function update() {
        $subscriptionName = $this->getname();
        $slugTitle = $this->slugify($subscriptionName);
        $sql = new Sql();
        $results = $sql->select("CALL sp_subscriptionsupdate_save(:id_subscription, :cod_subscription, :name, :name_color, :description, :url_slug, :subscription_active, :id_user)", array(
            ":id_subscription"=>$this->getid_subscription(),
            ":cod_subscription"=>$this->getcod_subscription(),
            ":name"=>$this->getname(),
            ":name_color"=>$this->getname_color(),
            ":description"=>$this->getdescription(),
	        ":url_slug"=>$slugTitle,
            ":subscription_active" => $this -> getsubscription_active(),
            ":id_user"=>$this->getid_user()
        ));
       
        $this->setData($results[0]);
    }

    public function slugify($text) {
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
      
  
    public function get($id_subscription) {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_subscriptions WHERE id_subscription = :id_subscription", array(
            ":id_subscription" => $id_subscription
        ));
        $this->setData($results[0]);
    }

    public function delete() {
    // Define o padrão do arquivo (ID seguido de qualquer extensão)
    $mask = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
            "res" . DIRECTORY_SEPARATOR . 
            "site" . DIRECTORY_SEPARATOR . 
            "img" . DIRECTORY_SEPARATOR . 
            "subscriptions" . DIRECTORY_SEPARATOR . 
            $this->getid_subscription() . ".*";

    // Buscar todos os arquivos que casam com a máscara e deleta um por um
    $files = glob($mask);
    if ($files) {
        array_map("unlink", $files);
    }

    // Deletar do banco de dados
    $sql = new Sql();
    $sql->query("DELETE FROM tb_subscriptions WHERE id_subscription = :id_subscription", [
        ":id_subscription" => $this->getid_subscription()
    ]);
}

    public function checkPhoto() {
        if (file_exists($_SERVER['DOCUMENT_ROOT']
            .DIRECTORY_SEPARATOR."res"
            .DIRECTORY_SEPARATOR."site"
            .DIRECTORY_SEPARATOR."img"
            .DIRECTORY_SEPARATOR."subscriptions"
            .DIRECTORY_SEPARATOR.$this->getid_subscription().".jpg")
            ) {
            $url = "/res/site/img/subscriptions/".$this->getid_subscription().".jpg";
        } else {
            $url = "/res/site/img/subscription.jpg";
        }
        return $this->setdesphoto($url);
    }

    public function getValues() {
        $this->checkPhoto();
        $values = parent::getValues();
        return $values;
    }
    


   public function setPhotos($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return; 
    }


    $fileContent = file_get_contents($file['tmp_name']);
    
    // Cria a imagem automaticamente detectando o formato (JPG, PNG, GIF, WebP...)
    $image = imagecreatefromstring($fileContent);

    if ($image !== false) {
        $dist = $_SERVER['DOCUMENT_ROOT']
            .DIRECTORY_SEPARATOR."res"
            .DIRECTORY_SEPARATOR."site"
            .DIRECTORY_SEPARATOR."img"
            .DIRECTORY_SEPARATOR."subscriptions"
            .DIRECTORY_SEPARATOR.$this->getid_subscription().".jpg";
            
        imagejpeg($image, $dist, 90);
        
        // Libera memória
        imagedestroy($image);
        
        $this->checkPhoto();
    } else {
        throw new \Exception("O arquivo enviado não é uma imagem válida ou o formato não é suportado pelo servidor.");
    }
}



    public function getPhotos() {
        $sql = new Sql();
        $resultsExistPhotos = $sql -> select("SELECT * FROM tb_photossubscription WHERE id_subscription = :id_subscription", [
          ":id_subscription" => $this -> getid_subscription()
        ]);
    
        $countResultsPhotos = count($resultsExistPhotos);
    
        if ($countResultsPhotos > 0) {
          foreach ($resultsExistPhotos as &$result) {
            foreach ($result as $key => $value) {
              if ($key === "name_photo") {
                $result["desphoto"] = "/res/site/img/subscriptions/" . $result["name_photo"];
              }
            }
          }
    
          return $resultsExistPhotos;
        }
      }
    public function getSubscriptionsPage($page = 1, $itemsPerPage = 10) {
        $start = ($page-1) * $itemsPerPage;
        $sql = new Sql();
        $results = $sql->select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_subscriptions ORDER BY id_subscription DESC LIMIT $start, $itemsPerPage");
        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");
        return [
            'data'=>Subscription::checkList($results),
            'total'=>(int)$resultTotal[0]["nrtotal"],
            'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
        ];
    }

    public function getFromURL($id_subscription, $url_slug)	{
        $sql = new Sql();
		$rows = $sql->select("SELECT * FROM tb_subscriptions WHERE id_subscription = :id_subscription AND url_slug = :url_slug", [
            ':id_subscription'=>$id_subscription,
            ':url_slug'=>$url_slug
        ]);
        if (count($rows) > 0) {
            return $this->setData($rows[0]);
        } else {
            header("Location: /blog");
            exit;
        }
    }
    
    public static function getSubscriptionsTotals() {
        $sql = new Sql();
        $results = $sql->select("SELECT COUNT(*) as nrqtd FROM tb_subscriptions");
        if (count($results) > 0) {
            return $results[0];
        } else {
            return [];
        }
    }

    

    public static function listAllLimit2() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_subscriptions ORDER BY id_subscription DESC");
    }

    public static function getCarouselSingle() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_subscriptions ORDER BY id_subscription DESC LIMIT 1");
    }

    public static function getCarousel() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_subscriptions WHERE id_subscription NOT IN(SELECT MAX(id_subscription) from tb_subscriptions) ORDER BY id_subscription DESC Limit 2");
    }

    public static function getLast3Subscription() {
        $sql = new Sql();
        return $sql -> select("SELECT * FROM tb_subscriptions ORDER BY id_subscription DESC LIMIT 3");
    }


    public static function setSuccess($msg) {
        update()[Subscription::SUCCESS] = $msg;
    }

}
