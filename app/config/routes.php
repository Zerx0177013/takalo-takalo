<?php

use app\controllers\CategoryController;
use app\controllers\RegisterController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ItemController;
use app\controllers\LoginController;
use app\controllers\AuthController;
/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {


	$router->get('/savage', function () use ($app) {
		$app->render('savage.test');
	});
	$router->group('/', function () use ($router, $app) {
		$authController = new AuthController($app);
		if (!$authController->isLogged()) {
			$router->post('/login', function () use ($app) {
				$email = $app->request()->data->email ?? null;
				$password = $app->request()->data->password ?? null;
				$authController = new AuthController($app);
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

			$router->post('/register', [RegisterController::class, 'register']);
		} else {

			$router->get('/logout', function () use ($app) {
				$authController = new AuthController($app);
				$authController->logOut();
				$app->redirect('/login');
			});

			$router->get('/dashboard', function () use ($app) {
				$app->render('dashboard');
			});

			$router->get('/', function () use ($app) {
				$controller = new ItemController($app);
				$app->render('index', ['items' => $controller->getAllItems()]);
			});

			$router->get('/propositions', [ItemController::class, 'propositions']);
			$router->get('/my-items', [ItemController::class, 'myItems']);


			$router->get('/items/new', function () use ($app) {
				$app->render('item-new', ['categories' => []]);
			});

			$router->post('/items', [ItemController::class, 'createItem']);

			$router->get('/categories', [CategoryController::class, 'renderCategoryList']);
			$router->get('/categories/@id', [CategoryController::class, 'renderCategoryDetail']);
		}
	});


}, [SecurityHeadersMiddleware::class]);