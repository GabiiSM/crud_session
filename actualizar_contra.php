
<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8" />

    <title>Actualizar COntrasena</title>

    <link rel="stylesheet" href="php.css" type="text/css" />

</head>

<body>

<div id="contenido">   

<h1>Estudiantes de Honor UPRA</h1>

<h2>contrasena generica a todos los estudiantes</h2>



<?php
include_once "db_info.php";
$pass = "passgen2023";
$hash = password_hash($pass, PASSWORD_DEFAULT);

$query = "UPDATE estudiantes
          SET psw = '$hash'";

    if($dbc -> query($query)===TRUE)
        print '<h3>COntrasenas han sido actualizadas exitosamente</h3>';
    else 
        print'<h3style="color:red;"> No se pudo actualizar la contrasena de los estudiantes ya que : <br/>'.$dbc->error.'</h3>';
    $dbc->close();
?>