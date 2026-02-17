<?php

use \Php\PageAdmin;
use \Php\Model\Occurrence;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/occurrences(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $occurrences = Occurrence::listAll();
    $page = new PageAdmin();
	$page->setTpl("occurrences", array(
		"occurrences"=>$occurrences,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/occurrences/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;
		
		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("occurrences-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

// $app->post("/admin/occurrences/create(/)", function() {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$occurrence = new Occurrence();
// 	$occurrence->setData($_POST);
// 	$occurrence->save();
// 	header("Location: /admin/occurrences/create");
// 	exit;
// });
$app->post("/admin/occurrences/create(/)", function() {
    $success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
    User::verifyLogin();
    User::verifyAccess();
    
    $occurrence = new Occurrence();
    $occurrence->setData($_POST);
    $occurrence->save();
    header("Location: /admin/occurrences/create?success=true&msg=" . urlencode("Ocorrência criada com sucesso."));
    exit;
});



$app->get("/admin/occurrences/:id_occurence/delete(/)", function($id_occurrence) {
	User::verifyLogin();
	User::verifyAccess();
	$occurrence = new Occurrence();
	$occurrence->get((int)$id_occurrence);
  $occurrence->delete();
  header("Location: /admin/occurrences");
	exit;
});

$app->get('/admin/occurrences/:id_occurrence(/)', function($id_occurrence) {
	$success = isset($_GET['success']) ? $_GET['success'] : 0;
	$error = isset($_GET['error']) ? $_GET['error'] : 0;
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$occurrence = new Occurrence();
	$occurrence->get((int)$id_occurrence);
	$page = new PageAdmin();
	$page->setTpl("occurrences-update", array(
		"occurrence"=>$occurrence->getValues(),
		"user"=>$user->getValues(),
		"success"=>$success,
		"error"=>$error
	));
});

// $app->post("/admin/occurrences/:id_occurrence(/)", function($id_occurrence) {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$occurrence = new Occurrence();
// 	$occurrence->get((int)$id_occurrence);
//     $occurrence->setData($_POST);
// 	$occurrence->update();
// 	header("Location: /admin/occurrences/$id_occurrence");
// 	exit;
// });

$app->post("/admin/occurrences/:id_occurrence(/)", function($id_occurrence) {
	$success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
	User::verifyAccess();
	$occurrence = new Occurrence();
	$occurrence->get((int)$id_occurrence);
    $occurrence->setData($_POST);
	$occurrence->update();
	header("Location: /admin/occurrences/{$id_occurrence}-update?success=true&msg=" . urlencode("Registro alterado com sucesso."));
	exit;
});




