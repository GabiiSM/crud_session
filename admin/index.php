<?php
session_start();
$titulo = "Estudiantes de Honor UPRA";

if (isset($_GET['ordenID'])) {
    $ordenID = $_GET['ordenID'];
    switch ($ordenID) {
        case 1:
            $orden = 'apellidoP, apellidoM, nombre ASC';
            break;
        case 2:
            $orden = 'numEST ASC';
            break;
        case 3:
            $orden = 'email ASC';
            break;
        case 4:
            $orden = 'nombreDepto ASC';
            break;
        case 0:
            $orden = 'promedio ASC';
            break;
    }
} else {
    $ordenID = 0;
    $orden = 'promedio DESC';
}

$limite = 5;

if (!isset($_GET['desde'])) {

    $desde = 0;
} else {

    $desde = $_GET['desde'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="php.css">
</head>

<body>
    <div>
        <h1>Estudiantes de Honor UPRA</h1>
        <?php
         if(isset($_SESSION['id']))
         {
        include_once("../db_info.php");
        $query = "SELECT COUNT(estID) as contador
                FROM estudiantes e, departamento d
                WHERE e.promedio>=3.30 AND e.deptoID = d.depto_ID";

        echo "<p>Query del count: $query</p>";

        $result = $dbc->query($query);
        $row = $result->fetch_assoc();
        $contador = $row['contador'];
        $total_pags = ceil($contador / $limite);
        $pag_actual = ceil($desde / $limite) + 1;

        echo "<p>La cantidad de récords es $contador</p>";
        echo "<p>La cantidad de páginas es $total_pags</p>";

        // $query = "SELECT * 
        //           FROM estudiantes
        //           INNER JOIN departamento 
        //           ON departamento.depto_ID=estudiantes.deptoID
        //           ORDER By $orden";

        $query = "SELECT *
                FROM estudiantes e, departamento d
                WHERE e.promedio>=3.30 AND e.deptoID = d.depto_ID
                ORDER BY $orden 
                LIMIT $limite OFFSET $desde";

        echo "<p>query: " . $query . "</p>";
        try {
            if ($result = $dbc->query($query)) {
                print "<table order=1>";
                print "<tr>
                                    <th></th>
                                    <th></th>
                                    <th><a href='index.php?ordenID=1'>Nombre</a></th>
                                    <th><a href='index.php?ordenID=2'>Numero de Estudiante</a></th>
                                    <th><a href='index.php?ordenID=3'>email</a></th>
                                    <th><a href='index.php?ordenID=4'>Departamento</a></th>
                                    <th><a href='index.php?ordenID=0'>Promedio</a></th>
                                </tr>";
                while ($row = $result->fetch_assoc()) {
                    $numESTMask = substr($row['numEST'], 0, 3) . "-" . substr($row['numEST'], 3, 2) . "-" . substr($row['numEST'], 5, 4);

                    print "<tr>
                            <td><a href='editar_estudiante.php?estID=" . $row['estID'] . "'>editar</a></td>
                            <td><a href='eliminar_estudiante.php?estID=" . $row['estID'] . "'>eliminar</a></td>
                            <td>" . $row['apellidoP'] . " " . $row['apellidoM'] . ", " . $row['nombre'] . " </td>
                            <td>" . $numESTMask . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['codigo'] . "</td>
                            <td>" . $row['promedio'] . "</td>
                        </tr>";

            
                }
                
                print "</table>";

                echo "<h2>";


                for ($i = 1; $i <= $total_pags; $i++)
                    echo "<a  class='btn pages' href='index.php?desde=" . (($i - 1) * $limite) . "&limite=$limite&ordenID=$ordenID'> $i </a>&nbsp;&nbsp;";

                echo "</h2>";
                echo '<h3><a href="insertar_estudiante_de_honor.php">Insertar récord de estudiante de honor</a></h3>';
            }
        } catch (Exception $e) {
            print "<h3 style=\"color:red\">Error en el query: " . $dbc->error . "</h3>";
        } finally {
            $dbc->close();
        }
        }
        else 
        print '<h3 style="color:red;">Esta Pagina ha sido accedida por error , haga <a href="../index.php">Login</a></h3>';
        ?>
    </div>
</body>

</html>