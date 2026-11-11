README: 
# TPEREST_WEBII_Cheves_DAnnunzio
### Datos integrantes
  - Cheves Nicolas, nicocheves99@gmail.com
  - D'Annunzio Julieta, dannunzio.julieta@gmail.com
---
### Temática del Trabajo Especial 
- API REST Catálogo de productos para una Tienda de Dispositivos Tecnológicos Apple.

-----
### Nueva tabla reviews
Se crea una nueva tabla de reseñas para que los usuarios puedan poner un comentario sobre el producto que compraron.
reviews
- id (PK)    INT
- name       VARCHAR
- review    VARCHAR
- created_at  DATE (automático)
- id_product (FK)
- calification INT (del 1 al 5)

  
### Objetivo del proyecto

Nuestra API REST permite que otros sitios o aplicaciones móviles puedan consultar el catálogo de productos Apple que tenemos disponible. Esto facilita que desarrolladores externos integren la información de los productos en sus propias plataformas o apps, manteniéndose siempre actualizados con los datos oficiales.

Además, se pueden consultar las reseñas de los usuarios para mostrar opiniones reales sobre cada producto, lo que puede mejorar la confianza de los clientes antes de realizar una compra.

**Endpoint para productos:**

GET /api/productos

    "products": [
        {
            "id": 2,
            "name": "Apple Watch Series 11",
            "img": "https://http2.mlstatic.com/D_NQ_NP_743107-CBT92553161980_092025-OO.jpg",
            "model": "Series 11",
            "price": 500,
            "description": "Reloj inteligente con pantalla Retina LTPO OLED y múltiples sensores.",
            "id_category": 2,
            "category_name": "Apple Watch  2025"
        },
        {
            "id": 13,
            "name": "Apple Watch SE",
            "img": "https://http2.mlstatic.com/D_NQ_NP_904908-MLA92851412157_092025-OO.jpg",
            "model": "SE",
            "price": 350,
            "description": "Reloj inteligente económico con funciones de salud y actividad.",
            "id_category": 2,
            "category_name": "Apple Watch  2025"
        },
        {
            "id": 22,
            "name": "Apple Watch Series 12",
            "img": "https://http2.mlstatic.com/D_NQ_NP_611645-MLA91903698062_092025-O.webp",
            "model": "Series 12",
            "price": 550,
            "description": "Reloj inteligente con medición de oxígeno y ECG.",
            "id_category": 2,
            "category_name": "Apple Watch  2025"
        }
        ]


**Endpoint opcional para reseñas:**

GET /api/reseñas

Endpoint: GET /api/reseñas

    
    - "reviews": [
        {
            "id": 1,
            "name": "María",
            "review": "Excelente diseño y precisión en el seguimiento de salud.",
            "created_at": "2025-11-12 18:37:07",
            "id_product": 2,
            "calification": 5,
            "product_name": "Apple Watch Series 11"
        },
        {
            "id": 3,
            "name": "Lucía",
            "review": "Muy cómodo y ligero, ideal para todo el día.",
            "created_at": "2025-11-12 18:37:07",
            "id_product": 2,
            "calification": 5,
            "product_name": "Apple Watch Series 11"
        },
        {
            "id": 4,
            "name": "Pedro",
            "review": "Sonido increíble y cancelación de ruido efectiva.",
            "created_at": "2025-11-12 18:37:07",
            "id_product": 3,
            "calification": 5,
            "product_name": "AirPods ProMax"
        }
    ]

**Uso posible:**

- Mostrar automáticamente el catálogo de productos Apple en un sitio web externo o app móvil.

- Consultar las reseñas más recientes para agregar información extra sobre cada producto y mejorar la decisión de compra de los usuarios.

- Todo esto se realiza para el público en general, mientras que la creación, edición o eliminación de productos requieren token y autenticación.

### Qué contiene este proyecto:                    

- Controladores
    - Autorización
    - Categoría
    - Producto
    - Review
- Middleware
- Modelos
    - Usuario
    - Categoría
    - Producto
    - Review
- Configuración
- Database (devices.sql)
- Librería interna de ruteo (jwt y router)
  - [README.md](./libs/router/README.md)
- api_router.php - Entry point para los endpoints de la API.
- .htaccess: reglas apache para soportar URL semánticas
----
### Endpoints

| MÉTODO      | ENDPOINT                                    | DESCRIPCIÓN  |
|-------------|---------------------------------------------|--------------|
| **GET**     | api/productos                           | Listar todos los productos |
| **GET**     | api/productos/id                        | Listar un producto por ID |
| **GET**     | api/categorias/1/productos              | Listar los productos de una categoría específica |
| **GET**     | api/productos?orderBy=name              | Ordenar productos por nombre |
| **GET**     | api/productos?orderBy=price             | Ordenar productos por precio  |
| **GET**     | api/productos?orderBy=model             | Ordenar productos por modelo |
| **GET**     | api/productos?orderBy=description       | Ordenar productos por descripcion |
| **GET**     | api/productos?orderBy=id_category       | Ordenar productos por categoría |
| **GET**     | api/productos?order=ASC                 | Ordenar productos ascendentemente |
| **GET**     | api/productos?order=DESC                | Ordenar productos descendentemente |
| **GET**     | api/productos?filterByName=apple        | Filtrar productos por nombre |
| **GET**     | api/productos?limit=5&page=1            | Listar productos paginados|
| **GET**     | api/categorias                          | Listar todas las categorías |
| **GET**     | api/categorias/id                       | Listar una categoría por ID |
| **GET**     | api/reseñas                             | Listar todas las reseñas |
| **GET**     | api/reseñas/id                          | Listar una reseña por ID |
| **GET**     | api/reseñas?orderBy=created_at          | Ordenar reseñas por fecha de creación |
| **GET**     | api/reseñas?orderBy=calification        | Ordenar reseñas por calificacion |
| **GET**     | api/reseñas?order=ASC                   | Ordenar reseñas ascendentemente |
| **GET**     | api/reseñas?order=DESC                  | Ordenar reseñas descendentemente |
| **POST**    | api/reseñas                             | Crear una reseña |
| **PUT**     | api/reseñas/id                          | Editar una reseña existente |
| **DELETE**  | api/reseñas/id                          | Eliminar una reseña |
| **POST**    | api/auth/login                          | Iniciar sesión  |
| **POST**    | api/productos                           | Crear un nuevo producto |
| **POST**    | api/categorias                          | Crear una nueva categoría |
| **PUT**     | api/productos/id                        | Editar un producto existente |
| **PUT**     | api/categorias/id                       | Editar una categoría existente |
| **DELETE**  | api/productos/id                        | Eliminar un producto |
| **DELETE**  | api/categorias/id                       | Eliminar una categoría |

### Aclaraciones:
- En el caso del filtrado, ordenamiento y paginacion, las URL's se pueden combinar, por ejemplo:
    -   api/productos?orderBy=model&order=ASC&limit=5&page=1 
-  Una vez que el usuario inicia sesión en POSTMAN, con la BasicAuth (webadmin-admin), ya con el TOKEN puede editar, crear o eliminar un producto o categoría.


