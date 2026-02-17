<?php

use \Php\PageAdmin;
use \Php\Model\Factoccurred;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/factoccurreds(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $factoccurreds = Factoccurred::listAll();
    $page = new PageAdmin();
	$page->setTpl("factoccurreds", array(
		"factoccurreds"=>$factoccurreds,
		"user"=>$user->getValues(),
		
	));
});

	$app->get("/admin/factoccurreds/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;
		User::verifyLogin();
		User::verifyAccess();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("factoccurreds-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/factoccurreds/create(/)", function() {
    $success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
	User::verifyAccess();
	$factoccurred = new Factoccurred();
	$factoccurred->setData($_POST);
	$factoccurred->save();
	header("Location: /admin/factoccurreds/create?success=true&msg=" . urlencode("Registro criado com sucesso."));
	exit;
});


$app->get("/admin/factoccurreds/:id_factoccurred/delete(/)", function($id_factoccurred) {
    // $success = isset($_GET['success']) && $_GET['success'] == 'true';
	// $error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
	User::verifyAccess();
	$factoccurred = new Factoccurred();
	$factoccurred->get((int)$id_factoccurred);
	$factoccurred->delete();
	header("Location: /admin/factoccurreds");
	// header("Location: /admin/factoccurreds?delete?success=true&msg=" . urlencode("Registro excluido com sucesso."));
	exit;
});

$app->get('/admin/factoccurreds/:id_factoccurred(/)', function($id_factoccurred) {
	// $success = isset($_GET['success']) ? $_GET['success'] : 0;
	// $error = isset($_GET['error']) ? $_GET['error'] : 0;
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$factoccurred = new Factoccurred();
	$factoccurred->get((int)$id_factoccurred);
	$page = new PageAdmin();
	$page->setTpl("factoccurreds-update", array(
		"factoccurred"=>$factoccurred->getValues(),
		"user"=>$user->getValues(),
		// "success"=>$success,
	    // "error"=>$error

	));
});

$app->post("/admin/factoccurreds/:id_factoccurred(/)", function($id_factoccurred) {
    // $success = isset($_GET['success']) && $_GET['success'] == 'true';
	// $error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
	User::verifyAccess();
	$factoccurred = new Factoccurred();
	$factoccurred->get((int)$id_factoccurred);
    $factoccurred->setData($_POST);
	$factoccurred->update();
	header("Location: /admin/factoccurreds/$id_factoccurred");
	// header("Location: /admin/factoccurreds/$id_factoccurred?update?success=true&msg=" . urlencode("Registro alterado com sucesso."));
	exit;
});




