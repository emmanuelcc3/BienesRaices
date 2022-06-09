<?php

namespace MVC;

class Router
{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn)
    {
        $this->rutasGET[$url] = $fn;
    }
    public function post($url, $fn)
    {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas()
    {
        session_start();

        $auth = $_SESSION['login'] ?? null;

        //Arreglo de rutas protegidas
        $rutas_protegidas = [
        '/admin',
        '/propiedades/crear',
        '/propiedades/actualizar',
        '/propiedades/eliminar',
        '/vendedores/crear',
        '/vendedores/actualizar',
        '/vendedores/eliminar'
    ];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';

        $metodo = $_SERVER['REQUEST_METHOD'];



        if ($metodo === 'GET') {

            $fn = $this->rutasGET[$urlActual] ?? NULL;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? NULL;
        }

        //Proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('location:/');
           
        }


        if ($fn) {
            //    es una funcion que nos permite llamar una funcion que no sabemos con se va a llamar
            call_user_func($fn, $this);
        } else {
            echo "Pagina No Encontrada";
        }

        //    debugear($urlActual);
    }
    ///Muestra una vista 
    public function render($view, $datos = [])
    {

        foreach ($datos as $key => $value) {
            $$key = $value; //$$ variable de variable
        }

        //Aqui vamos los datos en memoria de la vista
        ob_start();
        //lo que va hacer es que include __DIR__ . "/views/$view.php"; lo va a guardar en memoria
        include __DIR__ . "/views/$view.php";
        //aqui limpiamos esa memoria
        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
}
