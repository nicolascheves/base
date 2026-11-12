<?php
require_once './libs/router/router.php';

require_once './app/controllers/api/product-api.controller.php';
require_once './app/controllers/api/category-api.controller.php';
require_once './app/controllers/api/review-api.controller.php';
require_once './app/controllers/api/auth-api.controller.php';

require_once './libs/jwt/jwt.middleware.php';
require_once './app/middlewares/guard-api.middleware.php';

require_once './app/controllers/web/home.controller.php';
require_once './app/controllers/web/product.controller.php';
require_once './app/controllers/web/category.controller.php';
require_once './app/controllers/web/auth.controller.php';

require_once './app/middlewares/session.middleware.php';
require_once './app/middlewares/guard.middleware.php';

$apiRouter = new Router();
$webRouter = new Router();

// ---- API ----
$apiRouter->addMiddleware(new JWTMiddleware());

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

$apiRouter->addMiddleware(new ApiGuardMiddleware());

$apiRouter->addRoute('productos', 'POST', 'ProductApiController', 'insertProduct');
$apiRouter->addRoute('productos/:id', 'PUT', 'ProductApiController', 'updateProduct');
$apiRouter->addRoute('productos/:id', 'DELETE', 'ProductApiController', 'deleteProduct');

$apiRouter->addRoute('categorias', 'POST', 'CategoryApiController', 'insertCategory');
$apiRouter->addRoute('categorias/:id', 'PUT', 'CategoryApiController', 'updateCategory');
$apiRouter->addRoute('categorias/:id', 'DELETE', 'CategoryApiController', 'deleteCategory');


// ---- WEB ----
$webRouter->addMiddleware(new SessionMiddleware());

$webRouter->addRoute('home', 'GET', 'HomeController', 'showHome');
$webRouter->addRoute('producto/:id', 'GET', 'ProductController', 'showProductDetail');
$webRouter->addRoute('categoria/:id', 'GET', 'ProductController', 'showProductsByCategory');

$webRouter->addRoute('login', 'GET', 'AuthController', 'showLogin');
$webRouter->addRoute('do_login', 'POST', 'AuthController', 'doLogin');

$webRouter->addMiddleware(new WebGuardMiddleware());

$webRouter->addRoute('productos', 'GET', 'ProductController', 'showProducts');
$webRouter->addRoute('agregar-producto', 'GET', 'ProductController', 'showAddProductForm');
$webRouter->addRoute('agregar-producto', 'POST', 'ProductController', 'addProduct');

$webRouter->addRoute('editar-producto/:id', 'GET', 'ProductController', 'showEditFormProducts');
$webRouter->addRoute('editar-producto/:id', 'POST', 'ProductController', 'updateProduct');
$webRouter->addRoute('eliminar-producto/:id', 'POST', 'ProductController', 'removeProduct');

$webRouter->addRoute('categorias', 'GET', 'CategoryController', 'showCategories');
$webRouter->addRoute('agregar-categoria', 'GET', 'CategoryController', 'showAddCategoryForm');
$webRouter->addRoute('agregar-categoria', 'POST', 'CategoryController', 'addCategory');

$webRouter->addRoute('editar-categoria/:id', 'GET', 'CategoryController', 'showEditFormCategory');
$webRouter->addRoute('editar-categoria/:id', 'POST', 'CategoryController', 'editCategory');
$webRouter->addRoute('eliminar-categoria/:id', 'POST', 'CategoryController', 'removeCategory');

$webRouter->addRoute('logout', 'POST', 'AuthController', 'logout');

if (isset($_GET['resource'])) {
    $apiRouter->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
} else {
    session_start();
    define('BASE_URL', '//' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/BASE/');

    $action = $_GET['action'] ?? 'home';
    $webRouter->route($action, $_SERVER['REQUEST_METHOD']);
}
