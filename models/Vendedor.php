<?php

namespace Model;

class Vendedor extends ActiveRecord
{
    protected static $table = 'vendedores';
    //Aqui vemos que forma van a tener los daotos y que columnas va tener 
    protected static $columnasDB = ['id', 'nombre', 'apellido','telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

         /**CONSTRUIR LA REGISTRO*/
         public function __construct($args = [])
         {
     
             $this->id = $args['id'] ?? null;
             $this->nombre = $args['nombre'] ?? '';
             $this->apellido = $args['apellido'] ?? '';
             $this->telefono = $args['telefono'] ?? '';
            
         }

         
         public function validar()
    {


        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre";
        }
        if (!$this->apellido) {
            self::$errores[] = "Debes añadir un apellido";
        }
        if (!$this->telefono){
            self::$errores[] = "Debes añadir un telefono";
        }elseif (!preg_match('/[0-9]{8}/',$this->telefono) or strlen($this->telefono) > 8){
            self::$errores[] = "Telefono no es valido solo 8 numeros";
        }
        
        return self::$errores;
    }
}
