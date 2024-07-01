<?php
// Incluir archivo de configuración
require_once "config.php";

// Inicializar la sesión
session_start();

// Definir variables e inicializarlas con valores vacíos
$telefono = $password = "";
$telefono_err = $password_err = "";

// Procesar los datos del formulario cuando se envía
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Comprobar si el nombre de usuario está vacío
    if(empty(trim($_POST["telefono"]))){
        $telefono_err = "Por favor, ingrese su nombre de usuario.";
    } else{
        $telefono = trim($_POST["telefono"]);
    }

    // Comprobar si la contraseña está vacía
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validar credenciales
    if(empty($telefono_err) && empty($password_err)){
        // Preparar una declaración select
        $sql = "SELECT id, telefono, password FROM users WHERE telefono = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_telefono);

            // Establecer parámetros
            $param_telefono = $telefono;

            // Intentar ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Almacenar el resultado
                mysqli_stmt_store_result($stmt);

                // Comprobar si el nombre de usuario existe, si es así, verificar la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Vincular variables de resultado
                    mysqli_stmt_bind_result($stmt, $id, $telefono, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // La contraseña es correcta, así que iniciar una nueva sesión
                            session_start();

                            // Almacenar datos en variables de sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["telefono"] = $telefono;

                            // Redirigir al usuario a la página de bienvenida
                            header("location: welcome.php");
                            exit();
                        } else{
                            // La contraseña no es válida, mostrar un mensaje de error
                            $password_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else{
                    // El nombre de usuario no existe, mostrar un mensaje de error
                    $telefono_err = "No se encontró ninguna cuenta con ese nombre de usuario.";
                }
            } else{
                echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }
        }

        // Cerrar declaración
        mysqli_stmt_close($stmt);
    }

    // Cerrar conexión
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Por favor, ingrese sus credenciales para iniciar sesión.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($telefono_err)) ? 'has-error' : ''; ?>">
                <label>Numero de telefono</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
                <span class="help-block"><?php echo $telefono_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>¿No tienes una cuenta? <a href="register.php">Registrate aquí</a>.</p>
        </form>
    </div>
</body>
</html>