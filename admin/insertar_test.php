<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Insertar Estudiante</title>
    <link rel="stylesheet" href="php.css" type="text/css" />
</head>
<body>
<div id="contenido">   
    <h1>Estudiantes de Honor UPRA</h1>
    <h2>Insertar Estudiante</h2>
    <?php
    include("db_info.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the form submission for inserting a new student
        $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
        $apellidoP = htmlspecialchars($_POST['apellidoP'], ENT_QUOTES, 'UTF-8');
        $apellidoM = htmlspecialchars($_POST['apellidoM'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $promedio = filter_input(INPUT_POST, 'promedio', FILTER_VALIDATE_FLOAT);
        $deptoID = filter_input(INPUT_POST, 'deptoID', FILTER_VALIDATE_INT);
        $nombreDepto = htmlspecialchars($_POST['nombreDepto'], ENT_QUOTES, 'UTF-8');
        if ($promedio <= 0 || $promedio > 4 || !is_numeric($promedio)) {
            $promedio = 0;
        }

        // if ($deptoID > 0 && $deptoID <= 13 && is_numeric($deptoID)) {
            // Perform data validation and filtering as needed

            // Insert the new student record
            $query = "INSERT INTO estudiantes (nombre, apellidoP, apellidoM, email, promedio, nombreDepto)
                    VALUES ('$nombre', '$apellidoP', '$apellidoM', '$email', '$promedio', '$nombreDepto')";

            if ($dbc->query($query) === TRUE) {
                echo '<h3>Estudiante insertado exitosamente.</h3>';
            } else {
                echo '<h3 style="color: red;">Error al insertar estudiante: ' . $dbc->error . '</h3>';
            }
        // } else {
        //     echo '<h3 style="color: red;">Error en los datos del estudiante.</h3>';
        // }
    }
    ?>
    <form action="insertar_test.php" method="post">
    <br><label for="nombre">Nombre:</label><br>
        <br><input type="text" name="nombre" required>
        <br> <label for="apellidoP">Apellido Paterno:</label><br>
        <input type="text" name="apellidoP" required>
        <br> <label for="apellidoM">Apellido Materno:</label><br>
        <input type="text" name="apellidoM">
        <br><label for="email">Email:</label><br>
        <input type="email" name="email" required>
        <br><label for="deptoID">Departamento:</label>  
        
        <select name="deptoID">
    <?php
    // Fetch department data from the database
    $query = "SELECT deptoID, nombreDepto FROM departamento";
    $result = $dbc->query($query);

    // Check if the query was successful
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $deptoID = $row['deptoID'];
            $nombreDepto = $row['nombreDepto'];
            
            echo "<option value='$deptoID'>$nombreDepto</option>";
        }
        // Free the result set
        $result->free();
    }
    ?>
</select>


<br><label for="promedio">Promedio:</label>
        <input type="number" name="promedio" step="0.01" min="0.00" max="4.00" required>
        <br><input type="submit" name="insert" value="Insertar Estudiante">
    </form>
    <h3><a href="index.php">Ver estudiantes</a></h3>
</div>
</body>
</html>
