<?php
$titulo = "Estudiantes de Honor UPRA";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="php.css">
</head>

<body>
    <div id="contenido">
        <h1>Estudiantes de Honor UPRA</h1>
        <h2>Eliminar Estudiante</h2>
        <?php
        include_once("db_info.php");

        if (isset($_GET['estID']) && is_numeric($_GET['estID'])) //vino del index
        {
            $query = "SELECT *
            FROM estudiantes
            WHERE estID={$_GET['estID']}";
            try {
                if ($result = $dbc->query($query)) {
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        print '<form action="eliminar_estudiante.php" method="post" >
                        <h3> Estas seguro wue desea eliminar al siguiente estudiante de honor:
                        ' . $row['nombre'] . ' ' . $row['apellidoP'] . ' ' . $row['apellidoM'] . ';
                        ' . $row['numEST'] . '?</h3>';

                        print '<input type="hidden" name="estID" value="' . $_GET['estID'] . '"/>';
                        print '<div style="text-align:center;">
                                    <input type="submit" ="çonfirm_delete" value="Eliminar Estudiante"/>
                                </div> </form>';
                    } else {
                        print '<h3 style="color:red;" >Error, el estudiante no se encontro en la tabla</h3>';
                    }
                }
            } catch (Exception $e) {
                print '<h3 style="color:red;" >Error en el query:' . $dbc->error . '</h3>';
            }
        } elseif (isset($_POST['estID']) && is_numeric($_POST['estID'])) //vino del form
        {
            $query = "DELETE FROM estudiantes WHERE estID={$_POST['estID']} LIMIT 1";
            if ($dbc->query($query) === TRUE)
                echo '<h3 class="centro"> El record del estudiante ha sido eliminado con exito.</h3>';
            else
                echo '<h3 class="centro">No se pudo eliminar al estudiante porque: <br/>' . $dbc->error . '</h3>';
        } else
            echo '<h3 class="centro" style="color:red;">Esta pagina ha sido accedido con error.</h3>';
        ?>
    </div>
</body>