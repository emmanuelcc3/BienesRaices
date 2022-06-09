<?php

namespace Model;

class Propiedad extends ActiveRecord
{
    protected static $table = 'propiedades';
    //Aqui vemos que forma van a tener los daotos y que columnas va tener 
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    public $id;
    public $titulo;
    public $imagen;
    public $precio;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

         /**CONSTRUIR LA REGISTRO*/
         public function __construct($args = [])
         {
     
             $this->id = $args['id'] ?? null;
             $this->titulo = $args['titulo'] ?? '';
             $this->imagen = $args['imagen'] ?? '';
             $this->precio = $args['precio'] ?? '';
             $this->descripcion = $args['descripcion'] ?? '';
             $this->habitaciones = $args['habitaciones'] ?? '';
             $this->wc = $args['wc'] ?? '';
             $this->estacionamiento = $args['estacionamiento'] ?? '';
             $this->creado = date('Y/m/d');
             $this->vendedorId = $args['vendedorId'] ?? '';
         }

         public function validar()
    {


        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
        if (strlen($this->descripcion) > 100) {
            self::$errores[] = "La descripcion es obligatorio y no puede exeder a 50 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "El número de habitaciones es obligator";
        }

        if (!$this->wc) {
            self::$errores[] = "El número de Baños es obligator";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "El número de estacionamiento es obligator";
        }

        if (!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        }
        if (!$this->imagen) {
            self::$errores []="La imagen de propiedad es obigatoria";
        }

        return self::$errores;
    }

}
