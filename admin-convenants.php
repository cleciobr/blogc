<?php

use \Php\PageAdmin;
use \Php\Model\Convenant;
use \Php\Model\User;

$app -> get("/admin/convenants(/)", function() {
  $user = new User();
  $user = User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
User::verifyNoTele3();
  $user = User::getFromSession();
  
  $convenants = Convenant::listAll();
  
  $page = new PageAdmin;
  $page -> setTpl("convenants", [
    "convenants" => $convenants,
    "user" => $user -> getValues()
  ]);
});

$app->get("/admin/convenants/create(/)", function () { 
  $user = new User();
  $user = User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
User::verifyNoTele3();
  $user = User::getFromSession();
  
  $page = new PageAdmin();
  $page -> setTpl("convenants-create", [
    "user" => $user -> getValues()
  ]);
});

$app->post("/admin/convenants/create(/)", function () { 
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
User::verifyNoTele3();
  $convenant = new Convenant();
/* Post does not inform which user made the change in database
  $_POST["id_user"] = (isset($_POST["id_user"])) ? 1 : 0;*/
  $convenant -> setData($_POST);
  
  $convenant -> save();
  header("Location: /admin/convenants");
  exit;
});

$app->get("/admin/convenants/:id_convenant/delete(/)", function ($id_convenant) {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
User::verifyNoTele3();
  $convenant = new Convenant();
  $convenant -> get((int)$id_convenant);
  $convenant -> delete();

  header("Location: /admin/convenants");
  exit;
});

$app->get("/admin/convenants/:id_convenant(/)", function ($id_convenant) {
  $user = new User();
  $user = User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
User::verifyNoTele3();
  $user = User::getFromSession();

  $convenant = new Convenant();
  $convenant -> get((int)$id_convenant);

  $page = new PageAdmin();
  $page -> setTpl("convenants-update", [
    "convenant" => $convenant -> getValues(),
    "user" => $user -> getValues()
  ]);
});

$app->post("/admin/convenants/:id_convenant(/)", function ($id_convenant) {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
User::verifyNoTele3();
  $convenant = new Convenant();
  $convenant -> get((int)$id_convenant);
  $_POST["id_user"] = (isset($_POST["id_user"])) ? 1 : 0;
  $convenant -> setData($_POST);
  $convenant -> update();

  header("Location: /admin/convenants");
  exit;
});
