<?php
class WebGuardMiddleware extends Middleware{
    public function match($url, $verb) {
        $protectedRoutes = [
            'productos',
            'agregar-producto',
            'editar-producto',
            'eliminar-producto',
            'categorias',
            'agregar-categoria',
            'editar-categoria',
            'eliminar-categoria',
            'logout'
        ];

        $segment = explode('/', trim($url, '/'))[0] ?? '';
        return in_array($segment, $protectedRoutes, true);
    }
    
    public function run($request,$response) {
        if($request->user) {
            return $request;
        } else {
            header("Location: ".BASE_URL."login");
            exit();
        }
    }
}
