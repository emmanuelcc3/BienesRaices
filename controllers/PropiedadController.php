<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        //Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', ['propiedades' => $propiedades, 'resultado' => $resultado,'vendedores' => $vendedores]);
    }
    public static function crear(Router $router)
    {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        //Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();


        //Ejecutar el codigo despues de que el usuario envia el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**Crea una nueva instancia */
            $propiedad = new Propiedad($_POST['propiedad']);

            //Subida de archivos////
            //Generar un nombre unico
            //md5 sirve para gasta /tomar un entedra conveitirla genera un id unico.
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //stear la imagen 
            //realiza un resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {

                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }


            //valio
            $errores = $propiedad->validar();

            //Revisar que el array de errores este vacio
            if (empty($errores)) {
                //crea carpeta
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                //Guarda la imagen
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                //GUARDA EN LA BASE DE DATOS
                $propiedad->guardar();
            }
        }


        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router)
    {
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();
        $id = redireccionar('/admin');
        $propiedad = Propiedad::find($id);

        //Ejecutar el codigo despues de que el usuario envia el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los atributos
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);
            // debugear($propiedad);
            //Validar
            $propiedad->validar();
            //Subida de archivos
            //md5 sirve para gasta /tomar un entedra conveitirla genera un id unico.
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            //Revisar que el array de errores este vacio
            if (empty($errores)) {
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    //Almacer imagen el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
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
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
