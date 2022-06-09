<?php


function conectaDB () : mysqli {
    $host="127.0.0.1";
    $port=3306;
    $socket="";
    $user="root";
    $password="";
    $dbname="bienes_raices";
    
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());
    

    

        if (!$con) {
            echo "Error no se puedo conectar";
            exit;
        }

        return $con;
        }
        
    
   
 
   





