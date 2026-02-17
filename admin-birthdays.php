<?php

use \Php\PageAdmin;
use \Php\Model\Birthday;
use \Php\Model\Department;
use \Php\Model\User;

// 1. LISTAGEM
$app->get("/admin/birthdays(/)", function() {
    User::verifyLogin();
    User::Accessgranted();
    $user = User::getFromSession();
    $birthdays = Birthday::listAll2();

    $page = new PageAdmin();
    $page->setTpl("birthdays", array(
        "birthdays"=>$birthdays,
        "user"=>$user->getValues()
    ));
});

// 2. ATIVOS
$app->get("/admin/birthdays/active(/)", function() {
    User::verifyLogin();
    User::Accessgranted();
    $user = User::getFromSession();
    $birthdays = Birthday::getListBirthdaysActive();
    $page = new PageAdmin();
    $page->setTpl("birthdays-active", array(
        "birthdays"=>$birthdays,
        "user"=>$user->getValues()
    ));
});

// 3. FORMULÁRIO DE CRIAÇÃO (GET) - IMPORTANTE ESTAR AQUI
$app->get('/admin/birthdays/create(/)', function() {
    User::verifyLogin();
    User::Accessgranted();
    $user = User::getFromSession();
    $departments = Department::getDepartments();
    $page = new PageAdmin();
    $page->setTpl("birthdays-create", [
        "user"=>$user->getValues(),
        "departments"=>$departments,
    ]);
});

// 4. PROCESSAR CRIAÇÃO (POST) com multipla fotos
$app->post("/admin/birthdays/create(/)", function() {
    User::verifyLogin();
    User::Accessgranted();

    $birthday = new Birthday();
    $_POST["birthday_active"] = (isset($_POST["birthday_active"])) ? 1 : 0;
    $dateInput = (isset($_POST['date_birthday']) && $_POST['date_birthday'] != "") ? $_POST['date_birthday'] : date('Y-m-d');
    
    $_POST['date_birthday'] = date('Y-m-d', strtotime($dateInput)); 

    $_POST['birthday_active'] = 1;
    $_POST['esp_birthday'] = $_POST['name_birthday'];
    $_POST['department'] = 'Geral'; 

    $birthday->setData($_POST);
    $birthday->save();

    $id_birthday = $birthday->getid_birthday(); 

    if (isset($_FILES['files']) && !empty($_FILES['files']['tmp_name'][0])) {
        $birthday->setPhotos($_FILES['files']);
    }

    $dateEmail = date('d/m', strtotime($dateInput));
    $emailDestino = $_POST['email_recipient'];
    // $birthday->sendBirthdayEmail($id_birthday, $_POST['name_birthday'], $emailDestino);
    // $birthday->sendBirthdayEmail($id_birthday, $_POST['name_birthday'], $dateEmail); 
    $enviadoComSucesso = $birthday->sendBirthdayEmail($id_birthday, $_POST['name_birthday'], $emailDestino);

    if ($enviadoComSucesso) {
        header("Location: /admin/birthdays/create?success=1");
        exit; // Adicionado
    } else {
        header("Location: /admin/birthdays/create?error=mail");
        exit; // Adicionado
    }
});


// 5. DELETAR
$app->get("/admin/birthdays/:id_birthday/delete(/)", function($id_birthday) {
    User::verifyLogin();
    User::Accessgranted();
    $birthday = new Birthday();
    $birthday->get((int)$id_birthday);
    $birthday->delete();
    header("Location: /admin/birthdays");
    exit;
});

$app->post("/admin/birthdays/delete-all(/)", function() {
    User::verifyLogin();
    User::Accessgranted();

    $ids = $_POST['ids'];

    if (!empty($ids)) {
        $idsArray = explode(',', $ids);
        
        foreach ($idsArray as $id) {
            $birthday = new Birthday();
            $birthday->get((int)$id);
            $birthday->delete(); 
        }
    }

    header("Location: /admin/birthdays?delete=success");
    exit;
});

// 6. EDITAR (GET) - SEMPRE POR ÚLTIMO
$app->get('/admin/birthdays/:id_birthday(/)', function($id_birthday) {
    User::verifyLogin();
    User::Accessgranted();
    
    $birthday = new Birthday();
    $birthday->get((int)$id_birthday);
    
    $data = $birthday->getValues();
    if (isset($data['date_birthday'])) {
        $data['date_birthday'] = date('Y-m-d', strtotime($data['date_birthday']));
    }

    $page = new PageAdmin();
    $page->setTpl("birthdays-update", array(
        "birthday"    => $data,
        "user"        => User::getFromSession()->getValues(),
        "departments" => Department::getDepartments(),
        "photos"      => $birthday->getPhotos() // <--- ADICIONE ESTA LINHA
    ));
});


// 7. SALVAR EDIÇÃO (POST)
$app->post("/admin/birthdays/:id_birthday(/)", function($id_birthday) {
    User::verifyLogin();
    User::Accessgranted();

    $birthday = new Birthday();
    $birthday->get((int)$id_birthday);
    $_POST["birthday_active"] = (isset($_POST["birthday_active"])) ? 1 : 0;
    if (!empty($_POST['date_birthday'])) {
        $_POST['date_birthday'] = date('Y-m-d', strtotime($_POST['date_birthday']));
    }

    // 2. DELETA SOMENTE OS ARQUIVOS MARCADOS (Se houver)
    if (isset($_POST['photos_to_delete']) && $_POST['photos_to_delete'] !== '') {
        $birthday->deleteSelectedPhotos($_POST['photos_to_delete']);
    }

    // 3. ADICIONA NOVAS FOTOS (Se o usuário selecionou mais)
    if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
        $birthday->setPhotos($_FILES['files']);
    }

    // 4. ATUALIZA OS DADOS NO BANCO
    $birthday->setData($_POST);
    $birthday->update();

    // NOTA: Não chamamos sendBirthdayEmail aqui para não reenviar o e-mail na edição.

    header("Location: /admin/birthdays?update=success");
    exit;
});