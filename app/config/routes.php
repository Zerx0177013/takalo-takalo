<?php

use app\controllers\ApiExampleController;
<<<<<<< HEAD
use app\controllers\ItemController;
=======
use app\controllers\CategoryController;
>>>>>>> ba04085a9f24499cfb7fd051cb3b973305a5515d
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
