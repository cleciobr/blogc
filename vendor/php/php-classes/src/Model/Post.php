<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Post extends Model {

    public static function listAll() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_posts");
    }

    public static function listAllLimit() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_posts ORDER BY id_post DESC LIMIT 8");
    }

    public static function listPost() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_posts");
    }

    public static function checkList($list) {
        foreach ($list as &$row) {
            $p = new Post();
			$p->setData($row);
			$row = $p->getValues();
        }
        return $list;
    }


    public function save() {
        $postTitle = $this->gettitulo();
        $slugTitle = $this->slugify($postTitle);
        $sql = new Sql();
        $results = $sql->select("CALL sp_posts_save(:titulo, :autor, :texto, :url_slug, :post_active, :id_user)", array(
            ":titulo"=>$this->gettitulo(),
            ":autor"=>$this->getautor(),
            ":texto"=>$this->gettexto(),
	        ":url_slug"=>$slugTitle,
            ":post_active" => $this -> getpost_active(),
            ":id_user"=>$this->getid_user()
        ));
        
        $this->setData($results[0]);
    }
   
    public function update() {
        $postTitle = $this->gettitulo();
        $slugTitle = $this->slugify($postTitle);
        $sql = new Sql();
        $results = $sql->select("CALL sp_postsupdate_save(:id_post, :titulo, :autor, :texto, :url_slug, :post_active, :id_user)", array(
            ":id_post"=>$this->getid_post(),
            ":titulo"=>$this->gettitulo(),
            ":autor"=>$this->getautor(),
            ":texto"=>$this->gettexto(),
	        ":url_slug"=>$slugTitle,
            ":post_active" => $this -> getpost_active(),
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
      
  
    public function get($id_post) {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_posts WHERE id_post = :id_post", array(
            ":id_post" => $id_post
        ));
        $this->setData($results[0]);
    }

    public function delete() {
    // 1. Padrão de máscara (ID + qualquer extensão)
    // Mudar para .png, o código continua funcionando
    $mask = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
            "res" . DIRECTORY_SEPARATOR . 
            "site" . DIRECTORY_SEPARATOR . 
            "img" . DIRECTORY_SEPARATOR . 
            "posts" . DIRECTORY_SEPARATOR . 
            $this->getid_post() . ".*";

    $files = glob($mask);
    if ($files) {
        array_map("unlink", $files);
    }

    $sql = new Sql();
    $sql->query("DELETE FROM tb_posts WHERE id_post = :id_post", [
        ":id_post" => $this->getid_post()
    ]);
}

    public function checkPhoto() {
        if (file_exists($_SERVER['DOCUMENT_ROOT']
            .DIRECTORY_SEPARATOR."res"
            .DIRECTORY_SEPARATOR."site"
            .DIRECTORY_SEPARATOR."img"
            .DIRECTORY_SEPARATOR."posts"
            .DIRECTORY_SEPARATOR.$this->getid_post().".jpg")
            ) {
            $url = "/res/site/img/posts/".$this->getid_post().".jpg";
        } else {
            $url = "/res/site/img/post.jpg";
        }
        return $this->setdesphoto($url);
    }

    public function getValues() {
        $this->checkPhoto();
        $values = parent::getValues();
        return $values;
    }
    
   
    // public function setPhotos($file) {
    //     $extension = explode('.', $file['name']);
    //     $extension = end($extension);
    //     switch ($extension) {
    //         case 'jpg':
    //         case 'jpeg':
    //             $image = imagecreatefromjpeg($file['tmp_name']);
    //             break;
            
    //         case 'gif':
    //             $image = imagecreatefromgif($file['tmp_name']);
    //             break;

    //         case 'png':
    //             $image = imagecreatefrompng($file['tmp_name']);
    //             break;
    //     }
    //     $dist = $_SERVER['DOCUMENT_ROOT']
    //         .DIRECTORY_SEPARATOR."res"
    //         .DIRECTORY_SEPARATOR."site"
    //         .DIRECTORY_SEPARATOR."img"
    //         .DIRECTORY_SEPARATOR."posts"
    //         .DIRECTORY_SEPARATOR.$this->getid_post().".jpg";
    //     imagejpeg($image, $dist);
    //     imagedestroy($image);
    //     $this->checkPhoto();
    // }

   public function setPhotos($file) {
    // Verifica se o arquivo foi enviado sem erros
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return; // Ou trate o erro conforme sua necessidade
    }

    // Lê o conteúdo do arquivo
    $fileContent = file_get_contents($file['tmp_name']);
    
    // Cria a imagem automaticamente detectando o formato (JPG, PNG, GIF, WebP...)
    $image = imagecreatefromstring($fileContent);

    if ($image !== false) {
        $dist = $_SERVER['DOCUMENT_ROOT']
            .DIRECTORY_SEPARATOR."res"
            .DIRECTORY_SEPARATOR."site"
            .DIRECTORY_SEPARATOR."img"
            .DIRECTORY_SEPARATOR."posts"
            .DIRECTORY_SEPARATOR.$this->getid_post().".jpg";
            
        // Salva sempre como JPG (conforme seu padrão atual)
        imagejpeg($image, $dist, 90); // 90 é a qualidade
        
        // Libera memória
        imagedestroy($image);
        
        $this->checkPhoto();
    } else {
        throw new \Exception("O arquivo enviado não é uma imagem válida ou o formato não é suportado pelo servidor.");
    }
}



    public function getPhotos() {
        $sql = new Sql();
        $resultsExistPhotos = $sql -> select("SELECT * FROM tb_photospost WHERE id_post = :id_post", [
          ":id_post" => $this -> getid_post()
        ]);
    
        $countResultsPhotos = count($resultsExistPhotos);
    
        if ($countResultsPhotos > 0) {
          foreach ($resultsExistPhotos as &$result) {
            foreach ($result as $key => $value) {
              if ($key === "name_photo") {
                $result["desphoto"] = "/res/site/img/posts/" . $result["name_photo"];
              }
            }
          }
    
          return $resultsExistPhotos;
        }
      }
    public function getPostsPage($page = 1, $itemsPerPage = 10) {
        $start = ($page-1) * $itemsPerPage;
        $sql = new Sql();
        $results = $sql->select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_posts ORDER BY id_post DESC LIMIT $start, $itemsPerPage");
        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");
        return [
            'data'=>Post::checkList($results),
            'total'=>(int)$resultTotal[0]["nrtotal"],
            'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
        ];
    }

    public function getFromURL($id_post, $url_slug)	{
        $sql = new Sql();
		$rows = $sql->select("SELECT * FROM tb_posts WHERE id_post = :id_post AND url_slug = :url_slug", [
            ':id_post'=>$id_post,
            ':url_slug'=>$url_slug
        ]);
        if (count($rows) > 0) {
            return $this->setData($rows[0]);
        } else {
            header("Location: /blog");
            exit;
        }
    }
    
    public static function getPostsTotals() {
        $sql = new Sql();
        $results = $sql->select("SELECT COUNT(*) as nrqtd FROM tb_posts");
        if (count($results) > 0) {
            return $results[0];
        } else {
            return [];
        }
    }

    

    public static function listAllLimit2() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_posts ORDER BY id_post DESC");
    }

    public static function getCarouselSingle() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_posts ORDER BY id_post DESC LIMIT 1");
    }

    public static function getCarousel() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_posts WHERE id_post NOT IN(SELECT MAX(id_post) from tb_posts) ORDER BY id_post DESC Limit 2");
    }

    public static function getLast3Posts() {
        $sql = new Sql();
        return $sql -> select("SELECT * FROM tb_posts ORDER BY id_post DESC LIMIT 3");
    }

}
