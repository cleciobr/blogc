<?php

use \Php\PageAdmin;
use \Php\Model\User;
use \Php\Model\Department;
use \Php\Model\Consult;
use \Php\Model\Post;


$app->get('/admin/users(/)', function() {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	
	$user = new User();
	$user = User::getFromSession();
	// $alert = Consult::checkMaxSequenceOracle();
	// $datealert = Consult::getMaxdataPTMinserido();
	// $alertconsult= Consult::retrieveLastCheckMaxSequenceFromDatabase();
	$users = User::listAll();
	$page = new PageAdmin();
	$page->setTpl("users", array(
		"users"=>$users,
		// "alert"=>$alert,
		// "datealert"=>$datealert,
		// "alertconsult"=>$alertconsult,
		"user"=>$user->getValues()
	));
});

$app->get('/admin/users/create(/)', function() {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	$user = new User();
	$user = User::getFromSession();
	$departments = Department::getDepartments();
	// $alert= Consult::checkForNewRecords();
	
	$userimg = new User();
	$page = new PageAdmin();
	$page->setTpl("users-create", [
		"user"=>$user->getValues(),
		// "alert"=>$alert,
		"userimg"=>$userimg->getImageCreate(),
		"departments"=>$departments,
	]);
});

$app->post('/admin/users/create(/)', function() {
	User::verifyLogin();
	User::verifyMyuserAdmin();
    $user = new User();
	$_POST["user_active"] = (isset($_POST["user_active"])) ? 1 : 0;
	$user->setData($_POST);
	$user->save();
	if ((int)$_FILES["file"]["size"] > 0) {
        $user->setPhotos($_FILES["file"]);
    }
	header("Location: /admin/users/create");
	exit;
});

$app->get("/admin/users/:id_user/password(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	$user = new User();
	$user = User::getFromSession();
	// $alert= Consult::checkForNewRecords();
	$user->get((int)$id_user);
	$page = new PageAdmin();
	$page->setTpl("users-password", [
		"user"=>$user->getValues(),
		"msgError"=>User::getError(),
		// "alert"=>$alert,
		"msgSuccess"=>User::getSuccess()
	]);
});


$app->post("/admin/users/:id_user/password(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuserAdmin();

	if (!isset($_POST['senha']) || $_POST['senha'] === '') {
		User::setError("Preencha a nova senha.");
		header("Location: /admin/users/$id_user/password");
		exit;
	}
	if (!isset($_POST['senha-confirmada']) || $_POST['senha-confirmada'] === '') {
		User::setError("Preencha a confirmação da nova senha.");
		header("Location: /admin/users/$id_user/password");
		exit;
	}
	if ($_POST['senha'] !== $_POST['senha-confirmada']) {
		User::setError("Confirme corretamente as senhas.");
		header("Location: /admin/users/$id_user/password");
		exit;
	}
	$user = new User();
	$user->get((int)$id_user);
	$user->setPassword(User::getPasswordHash($_POST['senha']));
	User::setSuccess("Senha alterada com sucesso.");
	header("Location: /admin/users/$id_user/password");
	exit;
});


$app->get("/admin/users/:id_user/delete(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuserAdmin();

	$user = new User();
	$user->get((int)$id_user);
	$user->delete();
	header("Location: /admin/users");
	exit;
});

$app->get("/admin/users/:id_user(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	$user = new User();
	$user = User::getFromSession();
	$departments = Department::getDepartments();
	$user = new User();
	$user->get((int)$id_user);
	// $alert= Consult::checkForNewRecords();
	$page = new PageAdmin();
	$page->setTpl("users-update", [
		"user"=>$user->getValues(),
		// "alert"=>$alert,
		"userimg"=>$user->getValues(),
		"departments"=>$departments,
		
	]);
});


$app->post("/admin/users/:id_user(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	$user = new User();	
	$user->get((int)$id_user);
	$_POST["user_active"] = (isset($_POST["user_active"])) ? 1 : 0;
	$user->setData($_POST);
	$user->update();
	if ((int)$_FILES["file"]["size"] > 0) {
        $user->setPhotos($_FILES["file"]);
    }
	header("Location: /admin/users/$id_user");
	exit;
});
  



// My user
$app->get("/admin/myuser/:id_user/password(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuser();
	$user = new User();
	$user = User::getFromSession();
	// $alert= Consult::checkForNewRecords();
	$user->get($id_user);
	$page = new PageAdmin();
	$page->setTpl("myuser-password", [
		"user"=>$user->getValues(),
		// "alert"=>$alert,
		"msgError"=>User::getError(),
		"msgSuccess"=>User::getSuccess()
	]);
});


$app->post("/admin/myuser/:id_user/password(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuser();

	if (!isset($_POST['senha']) || $_POST['senha'] === '') {
		User::setError("Preencha a nova senha.");
		header("Location: /admin/myuser/$id_user/password");
		exit;
	}
	if (!isset($_POST['senha-confirmada']) || $_POST['senha-confirmada'] === '') {
		User::setError("Preencha a confirmação da nova senha.");
		header("Location: /admin/myuser/$id_user/password");
		exit;
	}
	if ($_POST['senha'] !== $_POST['senha-confirmada']) {
		User::setError("Confirme corretamente as senhas.");
		header("Location: /admin/myuser/$id_user/password");
		exit;
	}
	$user = new User();
	$user->get((int)$id_user);
	$user->setPassword(User::getPasswordHash($_POST['senha']));
	User::setSuccess("Senha alterada com sucesso.");
	header("Location: /admin/myuser/$id_user/password");
	exit;
});

$app->get("/admin/myuser/:id_user(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuser();
	$user = User::getFromSession();
	$departments = Department::getDepartments();
	// $alert= Consult::checkForNewRecords();
	$user->get((int)$id_user);
	
	$page = new PageAdmin();
	$page->setTpl("myuser-update", [
		"user"=>$user->getValues(),
		// "alert"=>$alert,
		"userimg"=>$user->getValues(),
		"departments"=>$departments,
		
	]);
});

$app->post("/admin/myuser/:id_user(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuser();
	$user = new User();	
	$user->get((int)$id_user);
	$user->setData($_POST);
	$user->update();
	if ((int)$_FILES["file"]["size"] > 0) {
        $user->setPhotos($_FILES["file"]);
    }
	header("Location: /admin");
	exit;
});

$app->get("/admin/myuseradmin/:id_user(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	$user = new User();
	$user = User::getFromSession();
	$departments = Department::getDepartments();
	// $alert= Consult::checkForNewRecords();
	$user = new User();
	$user->get((int)$id_user);
	
	$page = new PageAdmin();
	$page->setTpl("myuseradmin-update", [
		"user"=>$user->getValues(),
		// "alert"=>$alert,
		"userimg"=>$user->getValues(),
		"departments"=>$departments,
		
	]);
});

$app->post("/admin/myuseradmin/:id_user(/)", function($id_user) {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	$user = new User();	
	$user->get((int)$id_user);
	$user->setData($_POST);
	$user->update();
	if ((int)$_FILES["file"]["size"] > 0) {
        $user->setPhotos($_FILES["file"]);
    }
	header("Location: /admin/myuseradmin/$id_user");
	exit;
});

// $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1:0;
