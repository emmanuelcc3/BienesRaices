<?php

namespace Model;

class ActiveRecord {
        //BASE DE DATOS VA SER PROTECTED PARA QUE SOLO CLASE ACCEDA A LA BASE DE DATOS 
    //Esta estito por lo cual con recargo no se va no guardar por es estito

    protected static $con;
    //Aqui vemos que forma van a tener los daotos y que columnas va tener 
    protected static $columnasDB = [];
    //table
    protected static $table = '';
    //Errores
    protected static $errores = [];

     /**BUSCAR LA BB */
    public static function setDB($database)
    {
        self::$con = $database;
    }


     /**GUARDAR UN RESGISTRO */
    public function guardar() {
        if (!is_null($this->id)) {
            //actualizar
            $this->actualizar();

        }else {
            //crear un nuevo registro
            $this->crear();
        }
        
    }

     /**CREAR UN RESGISTRO */
    public function crear()
    {
        //Sanitizar los datos

        $atributos = $this->sanitizarAtributos();

        //Join sirve para hacer array en string
        // $string = join(', ', array_keys($atributos));
        //Insertar en la base de datos Esto se cambia para actualizar

        $query = "INSERT INTO " . static::$table . " (";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";

        //Esta estito por lo cual con recargo no se va no guardar por es estito -- el self se usa para static y this para cuando es publico.
        $resultado = self::$con->query($query);

        if ($resultado) {
            //Redicionar al usuario 
            header('Location: /admin?resultado=1');     
        }
    }

    /**ACTUALIZAR UN RESGISTRO */
    public function actualizar() {
     //Sanitizar los datos
     $atributos = $this->sanitizarAtributos();

     $valores = [];
     foreach($atributos as $key => $value){
         $valores[] = "{$key}='{$value}'";
     }
     $query = "UPDATE " . static::$table . " SET ";
     $query .= join(', ', $valores);
     $query .= " WHERE id = '" . self::$con->escape_String($this->id) . "' ";
     $query .= " LIMIT 1 ";
      
     $resultado = self::$con->query($query);

     if ($resultado) {
        //Redicionar al usuario 
        header('Location: /admin?resultado=2');
    }

    }
     /**ELIMINAR UN RESGISTRO */
    //Eliminar un registro
    public function eliminar() {
        //Eliminar la proiedad
        $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$con->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$con->query($query);
        if ($resultado) {
            $this->eliminarImagen();
            header('Location: /admin?resultado=3');
          }
    }

      /**IDENTIFICAR LOS ATRIBUTOS BD */
    //Identificar y unir los atributos de la BD;
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
     /**SANITIZAR LOS ATRIBUTOS*/
    public function sanitizarAtributos()
    {

        $atributos = $this->atributos();
        $sanitizando = [];

        foreach ($atributos as $key => $value) {
            $sanitizando[$key] = self::$con->escape_string($value);
        }
        return $sanitizando;
    }
     /**PARA SUBIR UN IMAGEN */
    //Subidad de archivos para
    public function setImagen($imagen)
    {
        //Eliminar la imagne previa con el id si id exite elimina la imagen
        if (!is_null($this->id)) {
            $this->eliminarImagen();
        }
        //Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
     /**PARA ELIMINAR UN IMAGEN PERO DEL SERVIDOR */
     public function eliminarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
     }

     /**VALIDAR ERRORES */
    //Validacion errores
    public static function getErrores()
    {
        return static::$errores;
    }
    public function validar()
    {
        static::$errores=[];
        return static::$errores;
    }

      /**SELECIONAR TODO LA TABLA EN BD */
    //lista todo las propiedades
    public static function all() {
        //Aqui llamos todo los datos de propiedades pero viene en arreglo ocupamos pasar a objectos
        $query = "SELECT * FROM " . static::$table;
        //entonces qui vamos esa consulta a la funcion consultarsql
        $resultado = self::consultarSQL($query);
         return $resultado;

    }
    //Obtiene determinado numero de registros
    public static function get($cantidad) {
        //Aqui llamos todo los datos de propiedades pero viene en arreglo ocupamos pasar a objectos
        $query = "SELECT * FROM " . static::$table . " LIMIT " . $cantidad;
        //entonces qui vamos esa consulta a la funcion consultarsql
        $resultado = self::consultarSQL($query);
         return $resultado;

    }

     /**BUSCAR UN REGISTRO POR ID */
    //Busca una registro por id
    public static function find($id){
        $query = "SELECT * FROM " . static::$table . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        
        return array_shift( $resultado);
    }

     /**CONSULTAR LA BD PARA PASAR EL ARRAY A OBJECTO */
    public static function consultarSQL($query){
        //Consultar la base de datos 
        $resultado = self::$con->query($query);

        //Iterar los resultados
        $array = [];//hacemos un array pero metener los datos asociativos pero se crea otro metodo que es crear el objecto
        while($registro = $resultado->fetch_assoc()){
            $array [] = static::crearObjecto($registro);
        }

        //liberar la memeroa
          $resultado->free();

        //retornar los resultados
        return $array;


    }
     /**CREAR UN OBJECTO*/
    protected static function crearObjecto($registro) {
         $objecto = new static;
           //Aqui lo formatiamos de arroy asi objecto
         foreach($registro as $key => $value){
             if (property_exists($objecto, $key)) {
                 $objecto->$key = $value;
                 //estos objecto solo se quedan en memoria y los agrega en el array consultasql
             }
         }
         return $objecto;
    }
     /**SINCRONIZA EL OBJECTO CON LOS DATOS DEL USUARIO */
    //Sincroniza el objecto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []){
      foreach($args as $key => $value){
          if(property_exists($this,$key) && !is_null($value)){
              $this->$key = $value;
          }
      }

    }
}
