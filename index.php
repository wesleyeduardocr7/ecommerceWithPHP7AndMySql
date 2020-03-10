<?php 

require_once("vendor/autoload.php");
use \Slim\Slim;
use Classes\Page;
use Classes\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index"); 

});

$app->get('/admin', function() {
    
	$pageAdmin = new PageAdmin();

	$pageAdmin->setTpl("index"); 

});

$app->run();

 ?>