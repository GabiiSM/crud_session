<?php $titulo = ""; ?>
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
        <h2>Lista de departamentos</h2>
        <?php
        include_once("db_info.php");
        $query = "SELECT nombre,nombreDepto FROM estudiantes  INNER JOIN  departamento on departamento.depto_ID = estudiantes.deptoID";

        try {
            if ($result = $dbc->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    print "<p>" . $row['nombre'] . " --> " . $row['nombreDepto'] . "</p>";
                    
                }
            }
        } catch (Exception $e) {
            print "<h3 style=\"color:red\">Error en el query: " . $dbc->error . "</h3>";
        } finally {
            $dbc->close();
        }

        ?>
    </div>
</body>

</html>