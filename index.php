<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>LOGIN - Estudiantes de Honor UPRA</title>
    <link rel="stylesheet" href="styles.css" type="text/css" />
</head>

<body>
<div id="contenido">
    <h1>Estudiantes de Honor - UPRA</h1>
    <h2>Autenticarse</h2>
<?php
//if (isset($_POST['submit']))
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
if( (!empty($_POST['email'])) && (!empty($_POST['pass'])) )
{ //conectarme a ver si existe ese estudiante de honor    
include_once("db_info.php");
            $email = $_POST['email'];
            $pass = $_POST['pass'];
           
            $query = "SELECT * FROM estudiantes
                      WHERE email = '$email'";
           
            $result = $dbc->query($query);
            if ($result->num_rows==1)
            {  
                $row = $result->fetch_assoc();
                echo "psw de la base de datos: ".$row['psw'];

                //  Redirigir el usuario a la página correspondiente
                if (password_verify($pass,$row['psw'])&&$row['rol']==0)
                {
                    
                    session_start();
                    $_SESSION['id'] = $row['estID'];
                    $_SESSION['nombre'] = $row['nombre'].' '.$row['apellidoP'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['rol'] = $row['rol'];
                    echo "<p>password correcto</p>";
                    header('Refresh:5 ;url= admin/index.php');
                   
                }
                elseif (password_verify($pass,$row['psw'])&&$row['rol']==1)
                {
                  session_start();

                  $_SESSION['id'] = $row['estID'];
                  $_SESSION['nombre'] = $row['nombre'].' '.$row['apellidoP'];
                  $_SESSION['email'] = $row['email'];
                  $_SESSION['rol'] = $row['rol'];
                  echo "<p>password correcto</p>";
                    header('Location: user/index.php');
                }
                else
                    echo "<p>password incorrecto</p>";
            }
            else
            {
                print '<h3>Su email no concuerda con nuestros archivos!<br />Vuelva a intentarlo...<a href="index.php"> Login </a></h3>';
            }
            $dbc->close();
        }
        else
        {   // No entró uno de los campos
  print '<h3>Asegúrese de entrar su email y número de estudiante. <br /> Vuelva a intentarlo...<a href="index.php"> Login </a></h3>';
   }
}
else // No llegó por un submit, por lo tanto hay que presentar el formulario
{  
print '<form action="index.php" method="post">
        <table border="0">
          <tr>
            <td width="140" align="right">email:</td>
            <td><input type="email" name="email" size="50" maxlength="60" required /></td>
          </tr>
          <tr>
            <td width="255" align="right">Password:</td>
            <td><input type="password" name="pass" ></td>
          </tr>
         
          <tr>
            <td></td>
            <td><input type="submit" class="formbutton" name="submit" value="Entrar!" /></td>
          </tr></table></form>';
}


?>
</div>
</body>
</html>