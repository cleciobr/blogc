<?php

use \Php\PageAdmin;
use \Php\Model\Degree_damg;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET degree_damgs
$app->get("/admin/degree_damgs(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $degree_damgs = Degree_damg::listAll();
    $page = new PageAdmin();
	$page->setTpl("degree_damgs", array(
		"degree_damgs"=>$degree_damgs,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/degree_damgs/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;

		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("degree_damgs-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/degree_damgs/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$degree_damg = new Degree_damg();
	$degree_damg->setData($_POST);
	$degree_damg->save();
	header("Location: /admin/degree_damgs/create");
	exit;
});


$app->get("/admin/degree_damgs/:id_degree_damg/delete(/)", function($id_degree_damg) {
	User::verifyLogin();
	User::verifyAccess();
	$degree_damg = new Degree_damg();
	$degree_damg->get((int)$id_degree_damg);
  $degree_damg->delete();
  header("Location: /admin/degree_damgs");
	exit;
});

$app->get('/admin/degree_damgs/:id_degree_damg(/)', function($id_degree_damg) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$degree_damg = new Degree_damg();
	$degree_damg->get((int)$id_degree_damg);
	$page = new PageAdmin();
	$page->setTpl("degree_damgs-update", array(
		"degree_damg"=>$degree_damg->getValues(),
		"user"=>$user->getValues()
	));
});

$app->post("/admin/degree_damgs/:id_degree_damg(/)", function($id_degree_damg) {
	$success = isset($_GET['success']) ? $_GET['success'] : 0;
	$error = isset($_GET['error']) ? $_GET['error'] : 0;

	User::verifyLogin();
	User::verifyAccess();
	$degree_damg = new Degree_damg();
	$degree_damg->get((int)$id_degree_damg);
    $degree_damg->setData($_POST);
	$degree_damg->update();
	
	header("Location: /admin/degree_damgs/$id_degree_damg");
	exit;
});




