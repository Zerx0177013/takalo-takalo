<?php

use app\controllers\ApiExampleController;
use app\controllers\CategoryController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ItemController;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	$router->group('/', function () use ($router, $app) {

		$authModel = new \app\models\AuthModel($app->db());
		if (!$authModel->isLoggedIn()) {

			$router->post('/login', function () use ($app) {
				$email = $app->request()->data->email ?? null;
				$password = $app->request()->data->password ?? null;
			});

			$router->get('/', function () use ($app) {
				$app->render('login');
			});

			$router->get('/login', function () use ($app) {
				$app->render('login');
			});

			$router->get('/register', function () use ($app) {
				$app->render('register');
			});
		} else {
			$router->get('/dashboard', function () use ($app) {
				$app->render('dashboard');
			});

			$router->post('/login', function () use ($app) {
				$email = $app->request()->data->email ?? null;
				$password = $app->request()->data->password ?? null;
			});

			$router->get('/', function () use ($app) {
				$controller = new ItemController($app);
				$app->render('index', ['items' => $controller->getAllItems()]);
			});

			$router->get('/my-items', [ItemController::class, 'myItems']);

			$router->get('/propositions', [ItemController::class, 'propositions']);

			$router->post('/exchange', [ItemController::class, 'createExchange']);
			$router->get('/categories', [CategoryController::class, 'renderCategoryList']);
			$router->get('/categories/@id', [CategoryController::class, 'renderCategoryDetail']);
		}
	});
}, [SecurityHeadersMiddleware::class]);
