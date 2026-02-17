<?php

use \Php\PageAdmin;
use \Php\Model\Event;
use \Php\Model\User;

$app->get("/admin/events(/)", function () {
  User::verifyLogin();
  User::Accessgranted();
  $user = User::getFromSession();

  $events = Event::listAll();

  $page = new PageAdmin();
  $page->setTpl("events", [
    "events" => $events,
    "user" => $user->getValues()
  ]);
});

$app->get("/admin/events/create(/)", function () {
  User::verifyLogin();
  User::Accessgranted();
  $user = new User();
  $user = User::getFromSession();

  $event = new Event();

  $page = new PageAdmin();
  $page->setTpl("events-create", [
    "user" => $user->getValues(),
    "event" => $event->getImageCreate()
  ]);
});

$app->post('/admin/events/create(/)', function () {
  User::verifyLogin();
  User::Accessgranted();
  $event = new Event();
  $event->setData($_POST);
  $event->save();
  // if ((int)$_FILES["files"]["size"] > 0) {
  //   $event->setPhotos($_FILES["files"], 1);
  // }
  if (isset($_FILES["files"]) && $_FILES["files"]["name"][0] != "") {
    $event->setPhotos($_FILES["files"], $event->getid_event()); 
 }
  header("Location: /admin/events/create");
  exit;
});

$app->get("/admin/events/:id_event/delete(/)", function ($id_event) {
  User::verifyLogin();
  User::Accessgranted();
  $event = new Event();
  $event->get((int)$id_event);
  $event->delete();

  header("Location: /admin/events");
  exit;
});

$app->post("/admin/events/delete-all(/)", function() {
    User::verifyLogin();
    User::Accessgranted();

    $ids = $_POST['ids'];

    if (!empty($ids)) {
        $idsArray = explode(',', $ids);
        foreach ($idsArray as $id) {
            $event = new Event();
            $event->get((int)$id);
            $event->delete(); 
        }
    }

    header("Location: /admin/events?delete=success");
    exit;
});

$app->post("/admin/events/:id_event(/)", function ($id_event) {
  User::verifyLogin();
  User::Accessgranted();
  
  $event = new Event();
  $event->get((int)$id_event);
  $event->setData($_POST);
  $event->update();
  
  // Lógica para salvar novas fotos
  $event->setPhotos($_FILES["files"], $id_event);

  // NOVO: A LÓGICA QUE REALMENTE DELETA
  if (isset($_POST['photos_to_delete']) && $_POST['photos_to_delete'] != '') {
      $idsToDelete = explode(',', $_POST['photos_to_delete']);
      foreach ($idsToDelete as $id_photo) {
          // Esta linha chama o método que apaga a imagem do DB e do servidor
          $event->deletePhoto((int)$id_photo); 
      }
  }

  header("Location: /admin/events/$id_event");
  exit;
});

$app->get("/admin/events/:id_event(/)", function ($id_event) {
  User::verifyLogin();
  User::Accessgranted();
  $user = new User();
  $user = User::getFromSession();

  $event = new Event();
  $event->get((int)$id_event);
  $event->getPhotos();

  $page = new PageAdmin();
  $page->setTpl("events-update", [
    "user" => $user->getValues(),
    "event" => $event->getValues(),
    "events" => $event->getPhotos()
  ]);
});

$app->post("/admin/events/:id_event(/)", function ($id_event) {
  User::verifyLogin();
  User::Accessgranted();
  $event = new Event();
  $event->get((int)$id_event);
  $event->setData($_POST);
  $event->update();
  $event->setPhotos($_FILES["files"], $id_event);

  header("Location: /admin/events/$id_event");
  exit;
});
