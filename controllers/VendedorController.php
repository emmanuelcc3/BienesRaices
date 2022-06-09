<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;

class VendedorController
{
    public static function crear(Router $router)
    {
        $vendedor = new Vendedor;

        //Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        //Ejecutar el codigo despues de que el usuario envia el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**Crea una nueva instancia */
            $vendedor = new Vendedor($_POST['vendedor']);
            //Validar campos vacios
            $errores = $vendedor->validar();
            //No hay errores hay que guardarlos
            if (empty($errores)) {
                $vendedor->guardar();
                # code...
            }
        }

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();
        $id = redireccionar('/admin');
        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**Crea una nueva instancia */
           $args = $_POST['vendedor'];
           //Sincronizar objecto en memoria con lo que le usuario escribio
           $vendedor -> sincronizar($args);
           //validacion
           $errores = $vendedor->validar();
        
           if (empty($errores)) {
               $vendedor->guardar();
           }
        
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            //para validar si el value no ponga delete * form propiedades
            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
