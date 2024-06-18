<?php $titulo = "";

$servername = 'localhost';  // Change this to 'localhost' if your database is on the same machine.
$dbname = 'gabsanma_db';  // Replace with the name of your local database.
$username = 'root';  // Replace with your database username.
$password = ''; 
$dbc = new mysqli($servername, $username, $password, $dbname);
if ($dbc->connect_error) {
    die("<p>La conexion al servidor fallo. Error: " . $dbc->connect_error . " </p>");
}
$dbc->query("SET NAMES 'utf8'");
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
        <?php ?>
    </div>
</body>

</html>
