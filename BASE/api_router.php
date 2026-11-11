<?php

require_once __DIR__ . '/libs/router/router.php';

require_once __DIR__ . '/app/controllers/api/product-api.controller.php';
require_once __DIR__ . '/app/controllers/api/category-api.controller.php';
require_once __DIR__ . '/app/controllers/api/review-api.controller.php';
require_once __DIR__ . '/app/controllers/api/auth-api.controller.php';
require_once __DIR__ . '/libs/jwt/jwt.middleware.php';
require_once __DIR__ . '/app/middlewares/guard-api.middleware.php';

require_once __DIR__ . '/app/controllers/web/home.controller.php';
require_once __DIR__ . '/app/controllers/web/product.controller.php';
require_once __DIR__ . '/app/controllers/web/category.controller.php';
require_once __DIR__ . '/app/controllers/web/auth.controller.php';
require_once __DIR__ . '/app/middlewares/session.middleware.php';
require_once __DIR__ . '/app/middlewares/guard.middleware.php';

$apiRouter = new Router();
$apiRouter->addMiddleware(new JWTMiddleware());

// Public API routes
$apiRouter->addRoute('auth/login', 'POST', 'AuthApiController', 'login');
$apiRouter->addRoute('productos', 'GET', 'ProductApiController', 'getProducts');
$apiRouter->addRoute('productos/:id', 'GET', 'ProductApiController', 'getProduct');
$apiRouter->addRoute('categorias', 'GET', 'CategoryApiController', 'getCategories');
$apiRouter->addRoute('categorias/:id', 'GET', 'CategoryApiController', 'getCategory');
$apiRouter->addRoute('categorias/:id/productos', 'GET', 'ProductApiController', 'getProductsByCategory');
$apiRouter->addRoute('reseñas', 'GET', 'ReviewApiController', 'getReviews');
$apiRouter->addRoute('reseñas/:id', 'GET', 'ReviewApiController', 'getReview');
$apiRouter->addRoute('productos/:id/reseñas', 'GET', 'ReviewApiController', 'getReviewsByProduct');
$apiRouter->addRoute('reseñas', 'POST', 'ReviewApiController', 'insertReview');
$apiRouter->addRoute('reseñas/:id', 'PUT', 'ReviewApiController', 'updateReview');
$apiRouter->addRoute('reseñas/:id', 'DELETE', 'ReviewApiController', 'deleteReview');

// Product/category mutations require a valid API token and role.
$apiGuard = new ApiGuardMiddleware();
$apiRouter->addRoute('productos', 'POST', 'ProductApiController', 'insertProduct', [$apiGuard]);
$apiRouter->addRoute('productos/:id', 'PUT', 'ProductApiController', 'updateProduct', [$apiGuard]);
$apiRouter->addRoute('productos/:id', 'DELETE', 'ProductApiController', 'deleteProduct', [$apiGuard]);
$apiRouter->addRoute('categorias', 'POST', 'CategoryApiController', 'insertCategory', [$apiGuard]);
$apiRouter->addRoute('categorias/:id', 'PUT', 'CategoryApiController', 'updateCategory', [$apiGuard]);
$apiRouter->addRoute('categorias/:id', 'DELETE', 'CategoryApiController', 'deleteCategory', [$apiGuard]);

$webRouter = new Router();
$webRouter->addMiddleware(new SessionMiddleware());

// Public website routes
$webRouter->addRoute('home', 'GET', 'HomeController', 'showHome');
$webRouter->addRoute('producto/:id', 'GET', 'ProductController', 'showProductDetail');
$webRouter->addRoute('categoria/:id', 'GET', 'ProductController', 'showProductsByCategory');
$webRouter->addRoute('login', 'GET', 'AuthController', 'showLogin');
$webRouter->addRoute('do_login', 'POST', 'AuthController', 'doLogin');

// Admin routes are protected individually; public pages remain accessible.
$webGuard = new WebGuardMiddleware();
$webRouter->addRoute('productos', 'GET', 'ProductController', 'showProducts', [$webGuard]);
$webRouter->addRoute('agregar-producto', 'GET', 'ProductController', 'showAddProductForm', [$webGuard]);
$webRouter->addRoute('agregar-producto', 'POST', 'ProductController', 'addProduct', [$webGuard]);
$webRouter->addRoute('editar-producto/:id', 'GET', 'ProductController', 'showEditFormProducts', [$webGuard]);
$webRouter->addRoute('editar-producto/:id', 'POST', 'ProductController', 'updateProduct', [$webGuard]);
$webRouter->addRoute('eliminar-producto/:id', 'POST', 'ProductController', 'removeProduct', [$webGuard]);
$webRouter->addRoute('categorias', 'GET', 'CategoryController', 'showCategories', [$webGuard]);
$webRouter->addRoute('agregar-categoria', 'GET', 'CategoryController', 'showAddCategoryForm', [$webGuard]);
$webRouter->addRoute('agregar-categoria', 'POST', 'CategoryController', 'addCategory', [$webGuard]);
$webRouter->addRoute('editar-categoria/:id', 'GET', 'CategoryController', 'showEditFormCategory', [$webGuard]);
$webRouter->addRoute('editar-categoria/:id', 'POST', 'CategoryController', 'editCategory', [$webGuard]);
$webRouter->addRoute('eliminar-categoria/:id', 'POST', 'CategoryController', 'removeCategory', [$webGuard]);
$webRouter->addRoute('logout', 'POST', 'AuthController', 'logout', [$webGuard]);

if (isset($_GET['resource'])) {
    $apiRouter->route((string) $_GET['resource'], $_SERVER['REQUEST_METHOD'] ?? 'GET');
} else {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/BASE/api_router.php')), '/') . '/';
    define('BASE_URL', '//' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $basePath);

    $webRouter->route((string) ($_GET['action'] ?? 'home'), $_SERVER['REQUEST_METHOD'] ?? 'GET');
}
