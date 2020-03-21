<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use Classes\Page;
use Classes\PageAdmin;
use Classes\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index"); 

});

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

$app->run();

 ?>