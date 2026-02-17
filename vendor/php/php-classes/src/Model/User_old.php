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

    public static function verifyLogin() {
        if (isset($_SESSION[User::SESSION]['inausente']) && $_SESSION[User::SESSION]['inausente'] === true) {
            header("Location: /admin/ausente");
            exit;
        } elseif (!isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION] || !(int)$_SESSION[User::SESSION]["id_user"] > 0) {
            header("Location: /admin/login");
            exit;
        }             
    }

    public static function verifyInadmin($inadmin = false) {
        if ($inadmin === false && (bool)$_SESSION[User::SESSION]['role'] == false) {
            header("Location: /dmin");
            exit;
        }
    }

    public static function verifyQualityUser($isQualityUser = 2) {
        if ($isQualityUser !== 2 && (int)$_SESSION[User::SESSION]['role'] !== 2) {
            header("Location: /dmin");
            exit;
        }
    }

    public static function logout() {
        $_SESSION[User::SESSION] = NULL;
    }

    public static function listAll() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_users");
    }

    public function save() {
        $sql = new Sql();
        $results = $sql->select("CALL sp_users_save(:desname, :login, :senha, :setor, :role)", array(
            ":desname"=>$this->getdesname(),
            ":login"=>$this->getlogin(),
            ":senha"=>User::getPasswordHash($this->getsenha()),
            ":setor"=>$this->getsetor(),
            ":role"=>$this->getrole()
        ));
        $this->setData($results[0]);
    }

    public static function getPasswordHash($senha) {
		return password_hash($senha, PASSWORD_DEFAULT, [
			'cost'=>12
		]);
    }
    
    public function get($iduser) {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE id_user = :id_user", array(
            ":id_user"=>$iduser
        ));
        $data = $results[0];
        $this->setData($data);
    }

    public function update() {
        $sql = new Sql();
        $results = $sql->select("CALL sp_usersupdate_save(:id_user, :desname, :login, :setor, :role)", array(
            ":id_user"=>$this->getid_user(),
            ":desname"=>$this->getdesname(),
            ":login"=>$this->getlogin(),
            ":setor"=>$this->getsetor(),
            ":role"=>$this->getrole()
        ));
        $this->setData($results[0]);
    }

    public function delete() {
        $sql = new Sql();
        $sql->query("CALL sp_users_delete(:id_user)", array(
            ":id_user"=>$this->getid_user()
        ));
    }

    public function setPassword($password) {
        $sql = new Sql();
        $sql->select("UPDATE tb_users SET senha = :senha WHERE id_user = :id_user", array(
            "senha"=>$password,
            ":id_user"=>$this->getid_user()
        ));
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
