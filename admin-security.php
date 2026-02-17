<?php

use \Php\PageAdmin;
use \Php\Model\Security;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/securitys(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $securitys = Security::listAll();
    $page = new PageAdmin();
	$page->setTpl("securitys", array(
		"securitys"=>$securitys,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/securitys/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;

		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("securitys-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/securitys/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$security = new Security();
	$security->setData($_POST);
	$security->save();
	header("Location: /admin/securitys/create");
	exit;
});


$app->get("/admin/securitys/:id_agenda/delete(/)", function($id_security) {
	User::verifyLogin();
	User::verifyAccess();
	$security = new Security();
	$security->get((int)$id_security);
  $security->delete();
  header("Location: /admin/securitys");
	exit;
});

$app->get('/admin/securitys/:id_security(/)', function($id_security) {
	$success = isset($_GET['success']) ? $_GET['success'] : 0;
	$error = isset($_GET['error']) ? $_GET['error'] : 0;
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$security = new Security();
	$security->get((int)$id_security);
	$page = new PageAdmin();
	$page->setTpl("securitys-update", array(
		"security"=>$security->getValues(),
		"user"=>$user->getValues(),
		"success"=>$success,
		"error"=>$error
	));
});

$app->post("/admin/securitys/:id_security(/)", function($id_security) {
	User::verifyLogin();
	User::verifyAccess();
	$security = new Security();
	$security->get((int)$id_security);
    $security->setData($_POST);
	$security->update();
	header("Location: /admin/securitys/$id_security");
	exit;
});




