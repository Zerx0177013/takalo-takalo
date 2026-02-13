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

$router->group('', function (Router $router) use ($app) {
	$router->get('/savage', function () use ($app) {
		$app->render('savage.test');
	});

	$router->group('/', function () use ($router, $app) {
		$router->post('/login', function () use ($app) {
			$email = $app->request()->data->email ?? null;
			$password = $app->request()->data->password ?? null;
			$authController = new AuthController($app);
			$controller = new ItemController($app);
			$user = $authController->login($email, $password);
			$authController->checkLogin('index', ['items' => $controller->getAllItemsExceptSelf()]);
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
			$authController->checkLogin('dashboard');
		});

		$router->get('/', function () use ($app) {
			$controller = new ItemController($app);
			$authController = new AuthController($app);
			if ($authController->isLogged())
				$app->render('index', ['items' => $controller->getAllItemsExceptSelf()]);
			else
				$app->redirect('/login');
		});

		$router->get('/propositions', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new ItemController($app);
				$controller->propositions();
			} else {
				$app->redirect('/login');
			}
		});

		$router->get('/my-items', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new ItemController($app);
				$controller->myItems();
			} else {
				$app->redirect('/login');
			}
		});

		$router->get('/mes-demandes', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new DemandeController($app);
				$controller->mesdemandes();
			} else {
				$app->redirect('/login');
			}
		});

		$router->get('/other-demandes', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new DemandeController($app);
				$controller->othersdemandes();
			} else {
				$app->redirect('/login');
			}
		});


		$router->get('/items/new', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new CategoryController($app);
				$controller->renderItemForm();
			} else {
				$app->redirect('/login');
			}
		});

		$router->get('/items/@id', function ($id) use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new ItemController($app);
				$controller->getItemById($id);
			} else {
				$app->redirect('/login');
			}
		});

		$router->delete('/items/@id', function ($id) use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new ItemController($app);
				$controller->deleteItem($id);
			} else {
				$app->json(['success' => false, 'message' => 'Unauthorized'], 401);
			}
		});

		$router->post('/items', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new ItemController($app);
				$controller->createItem();
			} else {
				$app->redirect('/login');
			}
		});

		$router->get('/categories', function () use ($app) {
			$authController = new AuthController($app);
			if ($authController->isLogged()) {
				$controller = new CategoryController($app);
				$controller->renderCategoryList();
			} else {
				$app->redirect('/login');
			}
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
	});
}, [SecurityHeadersMiddleware::class]);
