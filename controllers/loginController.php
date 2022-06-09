<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {
    public static function login(Router $router) {
        $errores = [];

     //Ejecutar el codigo despues de que el usuario envia el formulario
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $auth = new Admin($_POST);

        $errores = $auth->validar();

        if (empty($errores)) {
           //Verficar si el usuario Existe
          $resultado = $auth->existeUsuario();

          if (!$resultado) {
              //Verifica si el usuario existe o no (mensaje de error)
              $errores = Admin::getErrores();
              # code...
          }else {
              //Verficar el password
              $autenticado = $auth->comprobarPassword($resultado);

              if($autenticado){
                  //Autenticar al usuario    
                   $auth->autenticar();
              }else {
                  //password INCORRECTO
                $errores = Admin::getErrores();
              }

          }


        }


     }

        $router->render('auth/login',[
            'errores' => $errores
        ]);
    }

    public static function logout() {
           session_start();

           $_SESSION = [];

           header('Location: /');
    }
}