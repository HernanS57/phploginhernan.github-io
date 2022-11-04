<?php


function conectarDb () : mysqli {
    $db = mysqli_connect('us-cdbr-east-06.cleardb.net','bf6b4a5be7e289','3e106902',"heroku_120b9495e32a6c0");
    if (!$db){
        echo 'error no se pudo conectar';
        exit;
    }
    return $db;
}

