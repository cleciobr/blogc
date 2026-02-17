<?php

use \Php\PageAdmin;
use \Php\Model\Problem;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/problems(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $problems = Problem::listAll();
    $page = new PageAdmin();
	$page->setTpl("problems", array(
		"problems"=>$problems,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/problems/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;

		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("problems-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/problems/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$problem = new Problem();
	$problem->setData($_POST);
	$problem->save();
	header("Location: /admin/problems/create");
	exit;
});


$app->get("/admin/problems/:id_problem/delete(/)", function($id_problem) {
	User::verifyLogin();
	User::verifyAccess();
	$problem = new Problem();
	$problem->get((int)$id_problem);
  $problem->delete();
  header("Location: /admin/problems");
	exit;
});

$app->get('/admin/problems/:id_problem(/)', function($id_problem) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$problem = new Problem();
	$problem->get((int)$id_problem);
	$page = new PageAdmin();
	$page->setTpl("problems-update", array(
		"problem"=>$problem->getValues(),
		"user"=>$user->getValues()
	));
});

$app->post("/admin/problems/:id_problem(/)", function($id_problem) {
	User::verifyLogin();
	User::verifyAccess();
	$problem = new Problem();
	$problem->get((int)$id_problem);
    $problem->setData($_POST);
	$problem->update();
	header("Location: /admin/problems/$id_problem");
	exit;
});




