<?php

use \Php\PageAdmin;
use \Php\Model\Post;
use \Php\Model\User;

$app->get("/admin/posts(/)", function() {
    User::verifyLogin();
    User::Accessgranted();
    $user = new User();
	$user = User::getFromSession();
    $posts = Post::listAll();
    $page = new PageAdmin();
    $page->setTpl("posts", [
        "posts"=>$posts,
        "user"=>$user->getValues()
    ]);
});

$app->get('/admin/posts/create(/)', function() {
    User::verifyLogin();
    User::Accessgranted();
    $user = new User();
    $user = User::getFromSession();
    $post = new Post();
    $page = new PageAdmin();
	$page->setTpl("posts-create", [
        "user"=>$user->getValues(),
        "post"=>$post->getImageCreate()
    ]);
});

$app->post('/admin/posts/create(/)', function() {
    User::verifyLogin();
    User::Accessgranted();
    $post = new Post();
    $_POST["post_active"] = (isset($_POST["post_active"])) ? 1 : 0;
    $post->setData($_POST);
    $post->save();
    if ((int)$_FILES["file"]["size"] > 0) {
        $post->setPhotos($_FILES["file"]);
    }
    
    header("Location: /admin/posts/create");
    exit;
});

$app->get("/admin/posts/:id_post/delete(/)", function($id_post) {
    User::verifyLogin();
    User::Accessgranted();
    $post = new Post();
    $post->get((int)$id_post);
    $post->delete();
    
    header("Location: /admin/posts"); 
    exit;
});

$app->post("/admin/posts/delete-all(/)", function() {
    User::verifyLogin();
    User::Accessgranted();

    $ids = (isset($_POST['ids'])) ? $_POST['ids'] : '';

    if (!empty($ids)) {
        $idsArray = explode(',', $ids);
        foreach ($idsArray as $id) {
            $post = new Post(); 
            $post->get((int)$id);
            $post->delete();
        }
    }

    header("Location: /admin/posts?delete=success");
    exit;
});


$app->get("/admin/posts/:id_post(/)", function($id_post) {
    User::verifyLogin();
    User::Accessgranted();
    $user = new User();
    $user = User::getFromSession();
    $post = new Post();
    $post->get((int)$id_post);
    $page = new PageAdmin();
	$page->setTpl("posts-update", [
        "user"=>$user->getValues(),
        "post"=>$post->getValues(),
       
       
        
    ]);
});

$app->post('/admin/posts/:id_post(/)', function($id_post) {
    User::verifyLogin();
    User::Accessgranted();
    $post = new Post();
    $post->get((int)$id_post);
    $_POST["post_active"] = (isset($_POST["post_active"])) ? 1 : 0;
    $post->setData($_POST);
    $post->update();
    if ((int)$_FILES["file"]["size"] > 0) {
        $post->setPhotos($_FILES["file"]);
    }
    header("Location: /admin/posts/$id_post");
    exit;
});

