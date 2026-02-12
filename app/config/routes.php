<?php

use app\controllers\CategoryController;
use app\controllers\RegisterController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ItemController;
use app\controllers\LoginController;
use app\controllers\AuthController;
use app\controllers\DemandeController;
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
		$router->post('/login', function () use ($app) {
			$email = $app->request()->data->email ?? null;
			$password = $app->request()->data->password ?? null;
			$authController = new AuthController($app);
			$user = $authController->login($email, $password);
			$authController->checkLogin('/login');
		});


		$router->get('/login', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged())
				$app->redirect('/dashboard');
			else
				$app->render('login');
		});

		$router->get('/register', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged())
				$app->redirect('/dashboard');
			else
				$app->render('register');
		});

		$router->post('/register', [RegisterController::class, 'register']);

		$router->get('/logout', function () use ($app) {
			$authController = new AuthController($app);
			$authController->logOut();
			$app->redirect('/login');
		});

		$router->get('/dashboard', function () use ($app) {
			$authController = new AuthController($app);
			$authController->checkLogin('/dashboard');
		});

		$router->get('/', function () use ($app) {
			$controller = new ItemController($app);
			$authController = new AuthController($app);
			if ($authController->isLogged())
				$app->render('index', ['items' => $controller->getAllItemsExceptSelf()]);
			else $app->redirect('/login');
		});

		$router->get('/propositions', function () use ($app) {
			$authController = new AuthController($app);
			$authController->checkLogin('propositions', [ItemController::class, 'propositions']);
		});
		$router->get('/my-items', function () use ($app) {
			$authController = new AuthController($app);
			$authController->checkLogin('my-items', [ItemController::class, 'myItems']);
		});
		$router->get('/mes-demandes', function () use ($app) {
			$authController = new AuthController($app);
			$authController->checkLogin('mes-demandes', [DemandeController::class, 'mesdemandes']);
		});

		// Items routes
		$router->get('/items/new', [CategoryController::class, 'renderItemForm']);
		$router->get('/items/@id', [ItemController::class, 'getItemById']);
		$router->delete('/items/@id', [ItemController::class, 'deleteItem']);

		$router->post('/items', [ItemController::class, 'createItem']);

		// Categories CRUD routes
	$router->get('/categories', function () use ($app) {
		$authController = new AuthController($app);
		$authController->checkLogin('categories', [CategoryController::class, 'renderCategoryList']);
	});
	
	$router->get('/categories/@id/edit', function ($id) use ($app) {
		$authController = new AuthController($app);
		if ($authController->isLogged()) {
			$controller = new CategoryController($app);
			$controller->renderEditForm($id);
		} else {
			$app->redirect('/login');
		}
	});
	
	$router->get('/categories/@id', function ($id) use ($app) {
		$authController = new AuthController($app);
		if ($authController->isLogged()) {
			$controller = new CategoryController($app);
			$controller->renderCategoryDetail($id);
		} else {
			$app->redirect('/login');
		}
	});
	
	$router->post('/categories', function () use ($app) {
		$authController = new AuthController($app);
		if ($authController->isLogged()) {
			$controller = new CategoryController($app);
			$controller->createCategory();
		} else {
			$app->json(['success' => false, 'message' => 'Unauthorized'], 401);
		}
	});
	
	$router->put('/categories/@id', function ($id) use ($app) {
		$authController = new AuthController($app);
		if ($authController->isLogged()) {
			$controller = new CategoryController($app);
			$controller->updateCategory($id);
		} else {
			$app->json(['success' => false, 'message' => 'Unauthorized'], 401);
		}
	});
	
	$router->delete('/categories/@id', function ($id) use ($app) {
		$authController = new AuthController($app);
		if ($authController->isLogged()) {
			$controller = new CategoryController($app);
			$controller->deleteCategory($id);
		} else {
			$app->json(['success' => false, 'message' => 'Unauthorized'], 401);
		}
	});
}, [SecurityHeadersMiddleware::class]);