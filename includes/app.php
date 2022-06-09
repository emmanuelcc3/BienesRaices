<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

///Conectarme a la base de datos de la base de datos
$con = conectaDB();
use Model\ActiveRecord;

ActiveRecord::setDB($con);
?>