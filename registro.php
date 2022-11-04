<?php

require 'include/config/database.php';

$db = conectarDb();

$query = "SELECT * FROM usuarios";

$resultado = mysqli_query($db,$query);


$errores = [];
$exitos = [];

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $correo =  mysqli_real_escape_string($db,filter_var($_POST['correo'],FILTER_VALIDATE_EMAIL));
    $contraseña = mysqli_real_escape_string($db,$_POST['password']);

    if($correo && $contraseña){


        $query = "SELECT * FROM usuarios WHERE correo = '${correo}'";
        $resultadoConsulta = mysqli_query($db,$query);

        if($resultadoConsulta->num_rows === 0){
            if(strlen($contraseña) < 7){
                $errores[] = 'Tu contraseña debe tener minimo 8 caracteres';
            }
        }else{
            $errores[] = 'Este correo ya esta registrado';
        }

    }else{
        $errores[] = 'Debes digitar correo y contraseña';
    }

    if(empty($errores)){
        $exitos[] = "Registrado Correctamente...";
        $passwordHash = password_hash($contraseña,PASSWORD_DEFAULT);
        $queryData = "INSERT INTO usuarios (correo,password)  VALUES ('${correo}','${passwordHash}')";
        $envioDatos = mysqli_query($db,$queryData);
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <title>Registro</title>
</head>
<body>
    <main>
        <form method="POST" class="formulario">
            <legend>Registro</legend>
            <fieldset class="contenedor-inputs">
                <input name="correo" type="email" placeholder="CORREO">
                <input name="password" type="password" placeholder="CONTRASEÑA">
            </fieldset>
            <input class="boton" type="submit" class="boton-enviar" value="Registrarse">
            <div class="opciones">
                <a href="login.php">Volver</a>
            </div>
        </form>
        <div class="alerta">
            <?php foreach($errores as $error) : ?>
                <div class="error">
                    <?php echo "<p>${error}</p>" ?>
                </div>
            <?php endforeach; ?>
            <?php foreach($exitos as $exito) : ?>
                <div class="exito">
                    <?php echo "<p>${exito}</p>" ?>
                </div>
            <?php endforeach; ?>
        </div>

    </main>
</body>
</html>