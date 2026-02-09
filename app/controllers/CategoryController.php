<?php

namespace app\controllers;

use app\models\CategoryModel;
use flight\Engine;
use flight\Flight;

class CategoryController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

	public function renderCategoryList(): void {
		$categoryModel = new CategoryModel(Flight::db());
		$categories = $categoryModel->getAllCategories();

		// $this->app->render('categories', [
		// 	'categories' => $categories,
		// 	'currentPage' => 'categories',
		// ]);

		$this->app->json($categories, 200, true, 'utf-8', JSON_PRETTY_PRINT);

	}
}