<?php

use \Php\PageAdmin;
use \Php\Model\Patientsecurity;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/patientsecuritys(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $patientsecuritys = Patientsecurity::listAll();
    $page = new PageAdmin();
	$page->setTpl("patientsecuritys", array(
		"patientsecuritys"=>$patientsecuritys,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/patientsecuritys/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;

		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("patientsecuritys-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/patientsecuritys/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$patientsecurity = new Patientsecurity();
	$patientsecurity->setData($_POST);
	$patientsecurity->save();
	header("Location: /admin/patientsecuritys/create");
	exit;
});


$app->get("/admin/patientsecuritys/:id_patientsecurity/delete(/)", function($id_patientsecurity) {
	User::verifyLogin();
	User::verifyAccess();
	$patientsecurity = new Patientsecurity();
	$patientsecurity->get((int)$id_patientsecurity);
  $patientsecurity->delete();
  header("Location: /admin/patientsecuritys");
	exit;
});

$app->get('/admin/patientsecuritys/:id_patientsecurity(/)', function($id_patientsecurity) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$patientsecurity = new Patientsecurity();
	$patientsecurity->get((int)$id_patientsecurity);
	$page = new PageAdmin();
	$page->setTpl("patientsecuritys-update", array(
		"patientsecurity"=>$patientsecurity->getValues(),
		"user"=>$user->getValues()
	));
});

$app->post("/admin/patientsecuritys/:id_patientsecurity(/)", function($id_patientsecurity) {
	User::verifyLogin();
	User::verifyAccess();
	$patientsecurity = new Patientsecurity();
	$patientsecurity->get((int)$id_patientsecurity);
    $patientsecurity->setData($_POST);
	$patientsecurity->update();
	header("Location: /admin/patientsecuritys/$id_patientsecurity");
	exit;
});




