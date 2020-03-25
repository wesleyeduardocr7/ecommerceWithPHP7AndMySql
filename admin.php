<?php

use \Classes\PageAdmin;
use \Classes\Model\User;

$app->get('/admin', function() {

	User::verifyLogin();
    
	$pageAdmin = new PageAdmin();

	$pageAdmin->setTpl("index"); 

});

$app->get('/admin/login', function() {
    
	$pageAdmin = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$pageAdmin->setTpl("login"); 

});

$app->post('/admin/login', function() {
	
	User::login($_POST["login"],$_POST["password"]);

	header("Location: /admin");
	 
	exit;

});


$app->get('/admin/logout',function(){

	User::logout();

	header("Location: /admin/login");
	exit;

});




$app->get("/admin/forgot",function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot");

});

//Problema ao Localizar Rota | Funcionalidade Suspensa no Momento - 106
$app->post("/admin/forgot",function(){

	$user = User::getForgot($_POST["email"]);

	header("Location: /admin/forgot/sent");
	
	exit;
});

//Problema ao Localizar Rota | Funcionalidade Suspensa no Momento - 106
$app->get("/admin/forgot",function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-sent");

});

?>