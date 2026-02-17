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
    $birthdays = Birthday::listAll();
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
    
    // 1. CAPTURA E CONVERTE A DATA (Antes de salvar)
    $dateInput = (isset($_POST['date_birthday']) && $_POST['date_birthday'] != "") ? $_POST['date_birthday'] : date('Y-m-d');
    
    // Sobrescreve o POST com o formato dd/mm para o banco
    $_POST['date_birthday'] = date('d/m', strtotime($dateInput)); 

    // 2. CAMPOS ADICIONAIS
    $_POST['birthday_active'] = 1;
    $_POST['esp_birthday'] = $_POST['name_birthday'];
    $_POST['department'] = 'Geral'; 

    // 3. CARREGA OS DADOS E SALVA NO BANCO
    $birthday->setData($_POST);
    $birthday->save();

    // Pega o ID gerado para as fotos e e-mail
    $id_birthday = $birthday->getid_birthday(); 

    // 4. SALVA AS FOTOS
    if (isset($_FILES['files']) && !empty($_FILES['files']['tmp_name'][0])) {
        $birthday->setPhotos($_FILES['files']);
    }

    // 5. DISPARO DO E-MAIL
    $birthday->sendBirthdayEmail($id_birthday, $_POST['name_birthday']); 

    header("Location: /admin/birthdays?success=1");
    exit;
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

// 6. EDITAR (GET) - SEMPRE POR ÚLTIMO
$app->get('/admin/birthdays/:id_birthday(/)', function($id_birthday) {
    User::verifyLogin();
    User::Accessgranted();
    
    $birthday = new Birthday();
    $birthday->get((int)$id_birthday);
    
    $data = $birthday->getValues();

    // Ajuste da data para o <input type="date">
    if (isset($data['date_birthday']) && strpos($data['date_birthday'], '/') !== false) {
        $p = explode('/', $data['date_birthday']);
        $data['date_birthday'] = date('Y') . "-" . $p[1] . "-" . $p[0];
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

    // 1. TRATA A DATA (converte para o banco dd/mm)
    if (isset($_POST['date_birthday']) && !empty($_POST['date_birthday'])) {
        $_POST['date_birthday'] = date('d/m', strtotime($_POST['date_birthday']));
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