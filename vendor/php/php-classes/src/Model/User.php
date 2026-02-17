<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class User extends Model {

    const SESSION = "User";
    const ERROR = "UserError";
    const SUCCESS = "UserSucesss";

    public static function getFromSession() {
        $user = new User();
        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['id_user'] > 0) {
			$user->setData($_SESSION[User::SESSION]);
        }
        return $user;

    }

    public static function getFromSessionInadmin() {
        $user = new User();
        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['inadmin'] >= 0) {
            $user->setData($_SESSION[User::SESSION]);
        }
        return $user;
    
    }

    public static function login($login, $senha) {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE login = :LOGIN", array(
            ":LOGIN"=>$login
        ));
        if (count($results) === 0) {
            header("Location: /admin/login?erro=1");
            exit;
        }
        $data = $results[0];
        if (password_verify($senha, $data["senha"]) === true) {
            session_regenerate_id(true); //add recent
            $user = new User();
            $user->setData($data);
            $_SESSION[User::SESSION] = $user->getValues();
            $_SESSION[User::SESSION]['inausente'] = false;
            return $user;
        } else {
            header("Location: /admin/login?erro=1");
            exit;
        }
    }

    // public static function verifyLogin() {
    //     if (isset($_SESSION[User::SESSION]['inausente']) && $_SESSION[User::SESSION]['inausente'] === true) {
    //         header("Location: /admin/ausente");
    //         exit;
    //     } elseif (!isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION] || !(int)$_SESSION[User::SESSION]["id_user"] > 0) {
    //         header("Location: /admin/login");
    //         exit;
    //     }
    // }

     public static function verifyLogin() {
         if (!isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION]["id_user"]) {
             header("Location: /admin/login");
             exit;
         }
         if (isset($_SESSION[User::SESSION]['inausente']) && $_SESSION[User::SESSION]['inausente'] === true) {
             header("Location: /admin/ausente");
             exit;
         }
     }

    // public static function verifyLogin() {
    //         if (!isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION]["id_user"]) {
    //             header("Location: /admin/login");
    //             exit;
    //         }

    //         $tempoLimite = 1200; // 20 minutos em segundos (20 * 60)
    //         $agora = time();

    //         // Verifica se existe a marcação do último acesso
    //         if (isset($_SESSION['ultimo_acesso'])) {
    //             $tempoInativo = $agora - $_SESSION['ultimo_acesso'];

    //             if ($tempoInativo > $tempoLimite) {
    //                 $_SESSION[User::SESSION]['inausente'] = true;

    //                 header("Location: /admin/ausente");
    //                 exit;
    //             }
    //         }

    //         $_SESSION['ultimo_acesso'] = $agora;

    //         if (isset($_SESSION[User::SESSION]['inausente']) && $_SESSION[User::SESSION]['inausente'] === true) {
    //             header("Location: /admin/ausente");
    //             exit;
    //         }
    //     }



    public static function verifyActive() {
        if (isset($_SESSION[User::SESSION]['inausente']) && $_SESSION[User::SESSION]['inausente'] === true) {
            header("Location: /admin/ausente");
            exit;
        } elseif (!isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION] || !(int)$_SESSION[User::SESSION]["user_active"] > 0) {
            header("Location: /admin/login");
            exit;
        }
    }

    // Admin
         public static function verifyInadmin()  {
            $Access = "0";
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['inadmin'] > $Access)
        {
            // destroy the session
            session_destroy();
             // Redirects user back to login screen
            header("Location: /admin/login"); exit;
        }else{
            ($_SESSION);
        }
    }

     // Access only communications
     public static function verifyLogin2()  {
        $Access = "-1";
    // Checks the session variable that identifies the user
    if ($_SESSION[User::SESSION]['inadmin'] > $Access)
    {
        // destroy the session
        session_destroy();
        // Redirects user back to login screen
        header("Location: /admin/login"); exit;
    } 
    else{
        ($_SESSION);
    }
    }

     // Access index
     public static function Userindex()  {
        $Access = "0";
    // Checks the session variable that identifies the user
    if ($_SESSION[User::SESSION]['inadmin'] == "0" )
    {
        ($_SESSION);
    }
    elseif  ($_SESSION[User::SESSION]['inadmin'] == $Access)
    {
        ($_SESSION);
    }
    else{
         // destroy the session
         session_destroy();
         // Redirects user back to login screen
        header("Location: /admin/login"); exit;
    }
 }
    // Access notifications and admin
    public static function verifyNoAccess()  {
            $Access = "2";
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['inadmin'] != "0" )
        {
            header("Location: /"); exit;
        }
        else{
           
            header("Location: /"); exit;
        }
        }

    // Access notifications and admin
    public static function verifyAccess2()  {
        $Access = "2";
    // Checks the session variable that identifies the user
    if ($_SESSION[User::SESSION]['inadmin'] == "0" )
    {
        ($_SESSION);
    }
    elseif  ($_SESSION[User::SESSION]['inadmin'] == $Access)
    {
        ($_SESSION);
    }
    else{
        // destroy the session
        session_destroy();
        // Redirects user back to login screen
        header("Location: /admin/login"); exit;
    }
    }

    // Access notifications and admin
    public static function maintenance($requiredAccessLevel)  {
    if (isset($_SESSION[User::SESSION]['inadmin']) && ($_SESSION[User::SESSION]['inadmin'] == $requiredAccessLevel)) 
    {
        ($_SESSION);
    }
    else{
        header("Location: /admin/maintenance"); exit;
    }
    }


    public static function verifyAccessold($requiredAccessLevel) {
        if (isset($_SESSION[User::SESSION]['inadmin']) && ($_SESSION[User::SESSION]['inadmin'] == $requiredAccessLevel)) {
            return true;
        } else {
            session_destroy();
            header("Location: /admin/login"); exit;
            return false;
        }
    }
    public static function verifyAccess() {
        $Access0="0";
        $Access2="2";
        if (isset($_SESSION[User::SESSION]['inadmin']) && ($_SESSION[User::SESSION]['inadmin'] == $Access0)) {
            ($_SESSION);
        } 
        elseif (isset($_SESSION[User::SESSION]['inadmin']) && ($_SESSION[User::SESSION]['inadmin'] == $Access2))
        {
            ($_SESSION);
        }else {
            session_destroy();
            header("Location: /admin/login"); exit;
            return false;
        }
    }



    // Access communications and admin
    public static function verifyAccessCommunicationsDepartaments()  {
        $Access = "2";
    // Checks the session variable that identifies the user
    if ($_SESSION[User::SESSION]['inadmin'] == "0" )
    {
        ($_SESSION);
    }
    elseif  ($_SESSION[User::SESSION]['inadmin'] == $Access)
    {
        ($_SESSION);
    }
    else{
         // destroy the session
         session_destroy();
         // Redirects user back to login screen
        header("Location: /admin/login"); exit;
    }
 }

    // Access notifications and admin
    public static function verifyAccessNotificationscationsDepartaments()  {
            $Access = "2";
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['inadmin'] == "0" )
        {
            ($_SESSION);
        }
        elseif ($_SESSION[User::SESSION]['inadmin'] == $Access  )
        {
            ($_SESSION); 
        }
        else{
            // destroy the session
            session_destroy();
            // Redirects user back to login screen
            header("Location: /admin/login"); exit;
        }
    }


    //User Access Level 1 (USER), no permission
    public static function verifyNoUser1()  {
        $Access = "1";
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['inadmin'] == $Access)
        {
            // destroy the session
            session_destroy();
            // Redirects user back to login screen
            header("Location: /admin/login"); exit;
        }else{
            ($_SESSION);
        }
    }


    //User Access with permission
    public static function Accessgranted()  {
        $Access = "2";
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['inadmin'] == $Access)
        {
             ($_SESSION);

        }elseif($_SESSION[User::SESSION]['inadmin'] == "0")
        {
            ($_SESSION);
        }else{
            // destroy the session
            session_destroy();
            // Redirects user back to login screen
            header("Location: /admin/login"); exit;
            
        }

    }

     //User Access Level 2 (QUALITY), no permission
    public static function verifyNoQualy2()  {
        $Access = "2";
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['inadmin'] == $Access)
        {
            // destroy the session
            session_destroy();
             // Redirects user back to login screen
            header("Location: /admin/login"); exit;
        }else{
            ($_SESSION);
        }
    }

    

    //User Access Level 3 (TELE), no permission
    public static function verifyNoTele3()  {
        $Access = "3";
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['inadmin'] == $Access)
        {
            // destroy the session
            session_destroy();
             // Redirects user back to login screen
            header("Location: /admin/login"); exit;
        }else{
            ($_SESSION);
        }
    }

    //
    public static function verifyMyuserfg()  {
            if (isset($_SESSION[User::SESSION]['inausente']) && $_SESSION[User::SESSION]['inausente'] === true) {
                header("Location: /admin/ausente");
                exit;
            } elseif (isset($_SESSION[User::SESSION]['inadmin']) != $_SESSION[User::SESSION]['inadmin']) {
                header("Location: /admin/login");
                exit;
            }
        }

        //
        public static function verifyMyuser()  {
            $Access = $_SESSION[User::SESSION]['id_user'];
        // Checks the session variable that identifies the user
        if ($_SESSION[User::SESSION]['id_user'] == $Access)
        {
            ($_SESSION);
            //   var_dump($Access);
            //   exit;
            // destroy the session
            // session_destroy();
            // Redirects user back to login screen
        }else{
            header("Location: /admin");
            exit;
        }
        }

        //
        public static function verifyMyuserAdmin()  {
            $Access = "0";
            // Checks the session variable that identifies the user
            if ($_SESSION[User::SESSION]['inadmin'] != $Access)
            {
                // destroy the session
                session_destroy();
                // Redirects user back to login screen
                header("Location: /admin/login"); exit;
            }else{
                ($_SESSION);
            }
        }

    public static function logout() {
        $_SESSION[User::SESSION] = NULL;
    }

    public static function listAll() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_users");
    }

    public static function listUser() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_users where id_user = :id_user");
    }
    
    public static function checkList($list) {
        foreach ($list as &$row) {
            $p = new User();
			$p->setData($row);
			$row = $p->getValues();
        }
        return $list;
    }

    public function save() {
        $sql = new Sql();
        $results = $sql->select("CALL sp_users_save(:desname, :login, :senha, :setor, :inadmin, :user_active)", array(
            ":desname"=>$this->getdesname(),
            ":login"=>$this->getlogin(),
            ":senha"=>User::getPasswordHash($this->getsenha()),
            ":setor"=>$this->getsetor(),
            ":inadmin"=>$this->getinadmin(),
            ":user_active"=>$this->getuser_active(),
            
        ));
        $this->setData($results[0]);
    }


    public static function getPasswordHash($senha) {
		return password_hash($senha, PASSWORD_DEFAULT, [
			'cost'=>12
		]);
    }

    public function get($id_user) {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE id_user = :id_user", array( ":id_user"=>$id_user ));
        $data = $results[0];
    
        $this->setData($data);
    }

    public function getUserSession($id_user) {

        $id_user = new User();
        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['id_user'] > 0) {
            $id_user->setData($_SESSION[User::SESSION]);
            
        }
        return $id_user;



     }
   

    // public function update() {
    //     $sql = new Sql();
    //     $sql->select("UPDATE tb_users SET desname = :desname, login = :login, setor = :setor, inadmin = :inadmin, user_active = :user_active WHERE id_user = :id_user",  array(
    //         ":id_user"=>$this->getid_user(),
    //         ":desname"=>$this->getdesname(),
    //         ":login"=>$this->getlogin(),
    //         ":setor"=>$this->getsetor(),
    //         ":inadmin"=>$this->getinadmin(),
    //         ":user_active"=>$this->getuser_active()
    //     ));
       

    // }



     public function update() {
     $sql = new Sql();
     $sql->query("UPDATE tb_users SET 
         desname = :desname, 
         login = :login, 
         setor = :setor, 
         inadmin = :inadmin, 
         user_active = :user_active 
         WHERE id_user = :id_user", array(
         ":id_user"     => $this->getid_user(),
         ":desname"     => $this->getdesname(),
         ":login"       => $this->getlogin(),
         ":setor"       => $this->getsetor(),
         ":inadmin"     => (int)$this->getinadmin(),   
         ":user_active" => (int)$this->getuser_active() 
     ));
 }

   
    // public function update() {
    //      $sql = new Sql();
    //      $results = $sql->select("CALL sp_usersupdate_save(:id_user,:desname, :login, :senha, :setor, :inadmin, :user_active)", array(
    //          ":id_user"=>$this->getid_user(),
    //          ":desname"=>$this->getdesname(),
    //          ":login"=>$this->getlogin(),
    //          ":senha"=>User::getPasswordHash($this->getsenha()),
    //          ":setor"=>$this->getsetor(),
    //          ":inadmin"=>$this->getinadmin(),
    //          ":user_active"=>$this->getuser_active()
            
    //      ));
    //      $this->setData($results[0]);
    //  }

   
    public function setPassword($password) {
        $sql = new Sql();
        $sql->select("UPDATE tb_users SET senha = :senha WHERE id_user = :id_user", array(
            "senha"=>$password,
            ":id_user"=>$this->getid_user()
        ));
    }



    public function delete() {
        // 1. Primeiro, caminho da pasta dos usuários
        $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
                "res" . DIRECTORY_SEPARATOR . 
                "admin" . DIRECTORY_SEPARATOR . 
                "dist" . DIRECTORY_SEPARATOR . 
                "img" . DIRECTORY_SEPARATOR . 
                "users" . DIRECTORY_SEPARATOR;

        // 2. Encontrar o arquivo (ID.jpg, ID.png, etc)
        $mask = $path . $this->getid_user() . ".*";

        $files = glob($mask);
        if ($files) {
            array_map("unlink", $files);
        }

        $sql = new Sql();
        $sql->query("CALL sp_users_delete(:id_user)", array(
            ":id_user" => $this->getid_user()
        ));
    }
        



public function setPhotos($file) {
    $pathUsers = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
                 "res" . DIRECTORY_SEPARATOR . 
                 "admin" . DIRECTORY_SEPARATOR . 
                 "dist" . DIRECTORY_SEPARATOR . 
                 "img" . DIRECTORY_SEPARATOR . 
                 "users" . DIRECTORY_SEPARATOR;

    $dist = $pathUsers . $this->getid_user() . ".jpg";

    $defaultImage = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
                    "res" . DIRECTORY_SEPARATOR . 
                    "admin" . DIRECTORY_SEPARATOR . 
                    "dist" . DIRECTORY_SEPARATOR . 
                    "img" . DIRECTORY_SEPARATOR . "user.jpg";

    if (!isset($file['tmp_name']) || empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        
        if (file_exists($defaultImage)) {
            copy($defaultImage, $dist);
        }
        return $this->checkPhoto();
    }
    $fileContent = @file_get_contents($file['tmp_name']);
    if ($fileContent) {
        $image = @imagecreatefromstring($fileContent);
        if ($image !== false) {
            imagejpeg($image, $dist, 90);
            imagedestroy($image);
            $this->checkPhoto();
        } else {
            if (file_exists($defaultImage)) copy($defaultImage, $dist);
        }
    }
}



    // public function checkPhoto() {
    //     if (file_exists($_SERVER['DOCUMENT_ROOT']
    //         .DIRECTORY_SEPARATOR."res"
    //          .DIRECTORY_SEPARATOR."admin"
    //         .DIRECTORY_SEPARATOR."dist"
    //         .DIRECTORY_SEPARATOR."img"
    //         .DIRECTORY_SEPARATOR."users"
    //         .DIRECTORY_SEPARATOR.$this->getid_user().".jpg")
    //         ) {
    //         $url = "/res/admin/dist/img/users/".$this->getid_user().".jpg";
    //     } else {
    //         $url = "/res/admin/dist/img/user.jpg";
    //     }
    //     return $this->setdesphoto($url);
    // }


    public function checkPhoto() {
        $userPhoto = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
                    "res" . DIRECTORY_SEPARATOR . "admin" . DIRECTORY_SEPARATOR . 
                    "dist" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . 
                    "users" . DIRECTORY_SEPARATOR . $this->getid_user() . ".jpg";

        if (file_exists($userPhoto)) {
            $url = "/res/admin/dist/img/users/" . $this->getid_user() . ".jpg";
        } else {

            $pattern = $_SERVER['DOCUMENT_ROOT'] . "/res/admin/dist/img/user.*";
            $files = glob($pattern);

            if ($files && count($files) > 0) {
                $fileName = basename($files[0]);
                $url = "/res/admin/dist/img/" . $fileName;
            } else {
                $url = "/res/admin/dist/img/user.jpg";
            }
        }

        return $this->setdesphoto($url);
    }


     public function getPhotos() {
        $sql = new Sql();
         $resultsExistPhotos = $sql -> select("SELECT * FROM tb_photosuser WHERE id_user = :id_user", [
           ":id_user" => $this -> getid_user()
         ]);
        $countResultsPhotos = count($resultsExistPhotos);
    
        if ($countResultsPhotos > 0) {
          foreach ($resultsExistPhotos as &$result) {
            foreach ($result as $key => $value) {
              if ($key === "name_photo") {
                $result["desphoto"] = "/res/admin/dist/img/users/" . $result["name_photo"];
              }
            }
          }
    
          return $resultsExistPhotos;
        }
      }


    public function getPhotosId() {
    // 1. Verifica a sessão e carrega dados básicos se necessário
    if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['id_user'] > 0) {
        $this->setData($_SESSION[User::SESSION]);
    }

    // 2. Busca a foto no banco de dados
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_photosuser WHERE id_user = :id_user", [
        ":id_user" => $this->getid_user()
    ]);

    // 3. Processa o caminho da imagem
    if (count($results) > 0) {
        $photoData = $results[0]; // Pega a primeira foto encontrada
        $this->setdesphoto("/res/admin/dist/img/users/" . $photoData["name_photo"]);
    } else {
        // Opcional: define uma imagem padrão caso não encontre nenhuma
        $this->setdesphoto("/res/admin/dist/img/avatar-default.png");
    }

    return $this; // Retorna o próprio objeto atualizado
}

    public function getValues() {
        $this->checkPhoto();
        $values = parent::getValues();
        return $values;
    }




    public static function setError($msg) {
		$_SESSION[User::ERROR] = $msg;
    }

    public static function getError() {
        $msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : '';
        User::clearError();
        return $msg;
    }

	public static function clearError()	{
		$_SESSION[User::ERROR] = NULL;
    }

    public static function setSuccess($msg) {
        $_SESSION[User::SUCCESS] = $msg;
    }

	public static function getSuccess()	{
        $msg = (isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS]) ? $_SESSION[User::SUCCESS] : '';
        User::clearSuccess();
        return $msg;
    }

	public static function clearSuccess() {
        $_SESSION[User::SUCCESS] = NULL;
    }






}
