<?php

class SessionMiddleware extends Middleware{

    public function run($request, $response){
        if(isset($_SESSION['USER_ID'])){
            $request->user = new StdClass();
            $request->user->id = $_SESSION['USER_ID'];
            $request->user->username = $_SESSION['USER_NAME'];  
            // agregar desde la base de datos el resto de los datos del usuario si es necesario
             $request->user->userrole = $_SESSION['USER_ROLE'];
        } else {
            $request->user = null;
        }
        return $request;
    }

}
