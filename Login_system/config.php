<?php
// Configuración de la base de datos
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login_system');

// Intentar la conexión con la base de datos MySQL
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>