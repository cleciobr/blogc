<?php

use \Php\PageAdmin;
use \Php\Model\Conclusion;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/conclusions(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $conclusions = Conclusion::listAll();
    $page = new PageAdmin();
	$page->setTpl("conclusions", array(
		"conclusions"=>$conclusions,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/conclusions/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;

		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("conclusions-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/conclusions/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$conclusion = new Conclusion();
	$conclusion->setData($_POST);
	$conclusion->save();
	header("Location: /admin/conclusions/create");
	exit;
});


$app->get("/admin/conclusions/:id_conclusion/delete(/)", function($id_conclusion) {
	User::verifyLogin();
	User::verifyAccess();
	$conclusion = new Conclusion();
	$conclusion->get((int)$id_conclusion);
  $conclusion->delete();
  header("Location: /admin/conclusions");
	exit;
});

$app->get('/admin/conclusions/:id_conclusion(/)', function($id_conclusion) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$conclusion = new Conclusion();
	$conclusion->get((int)$id_conclusion);
	$page = new PageAdmin();
	$page->setTpl("conclusions-update", array(
		"conclusion"=>$conclusion->getValues(),
		"user"=>$user->getValues()
	));
});

$app->post("/admin/conclusions/:id_conclusion(/)", function($id_conclusion) {
	User::verifyLogin();
	User::verifyAccess();
	$conclusion = new Conclusion();
	$conclusion->get((int)$id_conclusion);
    $conclusion->setData($_POST);
	$conclusion->update();
	header("Location: /admin/conclusions/$id_conclusion");
	exit;
});




