<?php

use app\controllers\ApiExampleController;
use app\controllers\ItemController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	$router->get('/', function () use ($app) {
		$controller = new ItemController($app);
			$app->render('index', ['items' => $controller->getAllItems()]);
	});

	$router->get('/login', function () use ($app) {
		$app->render('login');
	});

	$router->get('/register', function () use ($app) {
		$app->render('register');
	});

}, [SecurityHeadersMiddleware::class]);
