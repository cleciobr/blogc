<?php

use \Php\PageAdmin;
use \Php\Model\Internacionalsecurity;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/internacionalsecuritys(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $internacionalsecuritys = Internacionalsecurity::listAll();
    $page = new PageAdmin();
	$page->setTpl("internacionalsecuritys", array(
		"internacionalsecuritys"=>$internacionalsecuritys,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/internacionalsecuritys/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;
		
		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("internacionalsecuritys-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

// $app->post("/admin/internacionalsecuritys/create(/)", function() {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$internacionalsecurity = new Internacionalsecurity();
// 	$internacionalsecurity->setData($_POST);
// 	$internacionalsecurity->save();
// 	header("Location: /admin/internacionalsecuritys/create");
// 	exit;
// });
$app->post("/admin/internacionalsecuritys/create(/)", function() {
    $success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
    User::verifyLogin();
    User::verifyAccess();
    
    $internacionalsecurity = new Internacionalsecurity();
    $internacionalsecurity->setData($_POST);
    $internacionalsecurity->save();
    header("Location: /admin/internacionalsecuritys/create?success=true&msg=" . urlencode("Ocorrência criada com sucesso."));
    exit;
});



$app->get("/admin/internacionalsecuritys/:id_occurence/delete(/)", function($id_internacionalsecurity) {
	User::verifyLogin();
	User::verifyAccess();
	$internacionalsecurity = new Internacionalsecurity();
	$internacionalsecurity->get((int)$id_internacionalsecurity);
  $internacionalsecurity->delete();
  header("Location: /admin/internacionalsecuritys");
	exit;
});

$app->get('/admin/internacionalsecuritys/:id_internacionalsecurity(/)', function($id_internacionalsecurity) {
	$success = isset($_GET['success']) ? $_GET['success'] : 0;
	$error = isset($_GET['error']) ? $_GET['error'] : 0;
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$internacionalsecurity = new Internacionalsecurity();
	$internacionalsecurity->get((int)$id_internacionalsecurity);
	$page = new PageAdmin();
	$page->setTpl("internacionalsecuritys-update", array(
		"internacionalsecurity"=>$internacionalsecurity->getValues(),
		"user"=>$user->getValues(),
		"success"=>$success,
		"error"=>$error
	));
});

// $app->post("/admin/internacionalsecuritys/:id_internacionalsecurity(/)", function($id_internacionalsecurity) {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$internacionalsecurity = new Internacionalsecurity();
// 	$internacionalsecurity->get((int)$id_internacionalsecurity);
//     $internacionalsecurity->setData($_POST);
// 	$internacionalsecurity->update();
// 	header("Location: /admin/internacionalsecuritys/$id_internacionalsecurity");
// 	exit;
// });

$app->post("/admin/internacionalsecuritys/:id_internacionalsecurity(/)", function($id_internacionalsecurity) {
	$success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
	User::verifyAccess();
	$internacionalsecurity = new Internacionalsecurity();
	$internacionalsecurity->get((int)$id_internacionalsecurity);
    $internacionalsecurity->setData($_POST);
	$internacionalsecurity->update();
	header("Location: /admin/internacionalsecuritys/{$id_internacionalsecurity}-update?success=true&msg=" . urlencode("Registro alterado com sucesso."));
	exit;
});




