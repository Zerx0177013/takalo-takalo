<?php

use app\controllers\CategoryController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ItemController;
use app\controllers\LoginController;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	$router->group('/', function () use ($router, $app) {
		$authController = new \app\controllers\AuthController($app);
		if (!$authController->isLogged()) {
			$router->post('/login', function () use ($app) {
				$email = $app->request()->data->email ?? null;
				$password = $app->request()->data->password ?? null;
				$authController = new \app\controllers\AuthController($app);
				$user = $authController->login($email, $password);
				if ($authController->isLogged())
					$app->redirect('/dashboard');
				else
					$app->redirect('/login');
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

			$router->get('/logout', function () use ($app) {
				$authController = new \app\controllers\AuthController($app);
				$authController->logOut();
				$app->redirect('/login');
			});

			$router->get('/dashboard', function () use ($app) {
				$app->render('dashboard');
			});

<<<<<<< HEAD
=======
			$router->post('/login', function () use ($app) {
				$email = $app->request()->data->email ?? null;
				$password = $app->request()->data->password ?? null;
			});

>>>>>>> 4d6af2e3221861514013b79780dfceb2f71e2b06
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
