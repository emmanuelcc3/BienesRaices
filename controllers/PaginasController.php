<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $inicio = true;
        $router->render('paginas/index',[
             'propiedades' => $propiedades,
             'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router) {

        $router->render('paginas/nosotros',[]);

    }
    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades',[
            'propiedades' => $propiedades      
       ]);
    }
    public static function propiedad(Router $router) {
        $id = redireccionar('/propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad',[
            'propiedad' => $propiedad     
       ]);
    }
    public static function blog(Router $router) {
            
        $router->render('paginas/blog',[]);
    }
    public static function entrada(Router $router) {
        $router->render('paginas/entrada',[]);
    }
    public static function contacto(Router $router) {
        $mensaje = null;
          //Ejecutar el codigo despues de que el usuario envia el formulario
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            
            $respuestas = $_POST['contacto'];

            //Crear una instancia de PHPMailer
            $mail = new PHPMailer();
            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = TRUE;
            $mail->Username = '5d0186a7da3322';
            $mail->Password = 'e1d40a50d5d4eb';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;
            
            //Configurar el contenido del mail

            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTML

            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html> ';
            $contenido .= '<p> Tienes un nuevo mensaje </p>';
            $contenido .= '<p> Nombre: ' .$respuestas['nombre'].'</p>';
           

            //Enviar de forma condicional algunos campos de emial o Telefono
            if($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Eligio ser contactado por Telefono a esta fecha y hora <p>'; 
                $contenido .= '<p> Telefono: ' .$respuestas['telefono'].'</p>';
                $contenido .= '<p> Fecha de contacto: ' .$respuestas['fecha'].'</p>';
                $contenido .= '<p> Hora: ' .$respuestas['hora'].'</p>';
            }else{
                $contenido .= '<p>Eligio ser contactado por email <p>'; 
                $contenido .= '<p> Email: ' .$respuestas['email'].'</p>'; 
            }
            $contenido .= '<p> Mensaje: ' .$respuestas['mensaje'].'</p>';
            $contenido .= '<p> Busca: ' .$respuestas['tipo'].'</p>';
            $contenido .= '<p> Precio: $' .$respuestas['precio'].'</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto texto alternativo';


            //Enviar el email
            if($mail->send()){
                $mensaje = "Mensaje enviado Correctamente";
            }else{
                $mensaje = "Mensaje no se puedo enviar";
            }


         }
        $router->render('paginas/contacto',['mensaje' => $mensaje]);

    }
  

}