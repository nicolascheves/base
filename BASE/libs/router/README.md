# Librería de ruteo ligera (libs/router)

Esta carpeta contiene una pequeña librería para enrutar peticiones HTTP en PHP. Está pensada para proyectos pequeños o como punto de partida educativo. La librería expone 3 clases principales:

- `Request` (en `request.php`)
- `Response` (en `response.php`)
- `Router` (en `router.php`)

La documentación siguiente explica cómo usar cada componente, ejemplos y notas sobre comportamiento.

## Instalación / inclusión

Simplemente incluye los archivos desde tu archivo de entrada (por ejemplo `api_router.php`). 
El archivo `router.php` ya incluye `request.php` y `response.php`, por lo que solo necesitas incluir `router.php`:

`require_once './libs/router/router.php';`


## Clases y API

### Router

`Router` representa la tabla de rutas y ejecución del ruteo.

Router API:
- `addRoute($url, $verb, $controller, $method)`: agrega una ruta. `$url` puede contener parámetros con prefijo `:` (ej. `/api/productos/:id`). `$verb` es el método HTTP en mayúsculas (`GET`, `POST`, `PUT`, `DELETE`, etc.). `$controller` es el nombre de la clase del controlador (string). `$method` es el nombre del método a invocar en ese controlador.
- `setDefaultRoute($controller, $method)`: configura una ruta por defecto que se ejecuta si no coincide ninguna ruta registrada.
- `addMiddleware($middleware)`: agrega un middleware. El middleware debe tener un método `run($request, $response)` que será ejecutado antes de resolver rutas.
- `route($url, $verb)`: resuelve y ejecuta la ruta que coincida con la URL y verbo. Antes de buscar rutas, ejecuta todos los middlewares registrados.

#### Ejemplo de registro de rutas (por ejemplo en `api_router.php`):

```
$router = new Router();

$router->addMiddleware(new JWTMiddleware());

// --- LOGIN --- //
$router->addRoute('auth/login', 'POST', 'AuthApiController', 'login');

// --- PRODUCTOS (públicos) --- //
$router->addRoute('productos', 'GET', 'ProductApiController', 'getProducts');
$router->addRoute('productos/:id', 'GET', 'ProductApiController', 'getProduct');

// --- CATEGORÍAS (públicas) --- //
$router->addRoute('categorias', 'GET', 'CategoryApiController', 'getCategories');
$router->addRoute('categorias/:id', 'GET', 'CategoryApiController', 'getCategory');
$router->addRoute('categorias/:id/productos', 'GET', 'ProductApiController', 'getProductsByCategory');

// --- REVIEWS (públicas) --- //
$router->addRoute('reseñas', 'GET', 'ReviewApiController', 'getReviews');
$router->addRoute('reseñas/:id', 'GET', 'ReviewApiController', 'getReview');
$router->addRoute('productos/:id/reseñas', 'GET', 'ReviewApiController', 'getReviewsByProduct');
$router->addRoute('reseñas', 'POST', 'ReviewApiController', 'insertReview');
$router->addRoute('reseñas/:id', 'PUT', 'ReviewApiController', 'updateReview');
$router->addRoute('reseñas/:id', 'DELETE', 'ReviewApiController', 'deleteReview');


// --- A partir de acá, requiere autenticación ---
$router->addMiddleware(new GuardMiddleware());

$router->addRoute('productos', 'POST', 'ProductApiController', 'insertProduct');
$router->addRoute('productos/:id', 'PUT', 'ProductApiController', 'updateProduct');
$router->addRoute('productos/:id', 'DELETE', 'ProductApiController', 'deleteProduct');
$router->addRoute('categorias', 'POST', 'CategoryApiController', 'insertCategory');
$router->addRoute('categorias/:id', 'PUT', 'CategoryApiController', 'updateCategory');
$router->addRoute('categorias/:id', 'DELETE', 'CategoryApiController', 'deleteCategory');


$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
```

### Request
Representa la solicitud enviada al servidor. El router envia este objeto al controlador asociado a la ruta.

- Propiedades públicas:
  - `body` (object|null): JSON decodificado del cuerpo de la petición (lee `php://input`).
  - `params` (object|null): parámetros capturados en la ruta (p. ej. `:id`).
  - `query` (object): parámetros de consulta (`$_GET`) convertidos a objeto.

Ejemplo de uso dentro de un controller:

```
public function update($request, $response) {
    $id = $request->params->id;     // parámetro de ruta
    $data = $request->body;         // body JSON (objeto)
    $order = $request->query->order ?? 'ASC';

}
```

### Response
Se utiliza para devolver respuestas a las solicitudes de los clientesa. El router envia este objeto al controlador asociado a la ruta.

- Métodos públicos:
  - `json($data, $status = 200)`: envía una respuesta JSON con el código HTTP y cabeceras apropiadas.

Ejemplo:

```
$response->json([
    "message" => "Producto creado correctamente"
], 201);
```


### Middlewares
La API usa middlewares para:
- Validar tokens JWT
- Proteger rutas de POST, PUT, DELETE

Ejemplo de uso en router:
```
$router->addMiddleware(new AuthMiddleware());
```



