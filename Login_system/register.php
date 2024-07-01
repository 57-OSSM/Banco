<?php
// Incluir archivo de configuración
require_once "config.php";

// Definir variables e inicializarlas con valores vacíos
$telefono = $password = $confirm_password = "";
$telefono_err = $password_err = $confirm_password_err = "";

// Procesar los datos del formulario cuando se envía
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validar nombre de usuario
    if(empty(trim($_POST["telefono"]))){
        $telefono_err = "Por favor, ingrese un nombre de usuario.";
    } else{
        // Preparar una declaración select
        $sql = "SELECT id FROM users WHERE telefono = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_telefono);
            
            // Establecer parámetros
            $param_telefono = trim($_POST["telefono"]);
            
            // Intentar ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                /* almacenar resultado */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $telefono_err = "Este nombre de usuario ya está tomado.";
                } else{
                    $telefono = trim($_POST["telefono"]);
                }
            } else{
                echo "Error al ejecutar la declaración: " . mysqli_stmt_error($stmt);
            }
        } else{
            echo "Error al preparar la declaración: " . mysqli_error($conn);
        }
         
        // Cerrar declaración
        if ($stmt) {
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validar contraseña
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, ingrese una contraseña.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validar confirmación de contraseña
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, confirme la contraseña.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }
    
    // Comprobar los errores de entrada antes de insertar en la base de datos
    if(empty($telefono_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Preparar una declaración insert
        $sql = "INSERT INTO users (telefono, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "ss", $param_telefono, $param_password);
            
            // Establecer parámetros
            $param_telefono = $telefono;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Crear un hash de la contraseña
            
            // Intentar ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Redirigir a la página de login
                header("location: login.php");
            } else{
                echo "Error al ejecutar la declaración: " . mysqli_stmt_error($stmt);
            }
        } else{
            echo "Error al preparar la declaración: " . mysqli_error($conn);
        }
         
        // Cerrar declaración
        if ($stmt) {
            mysqli_stmt_close($stmt);
        }
    }
    
    // Cerrar conexión
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Registro</h2>
        <p>Por favor, complete este formulario para crear una cuenta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($telefono_err)) ? 'has-error' : ''; ?>">
                <label>Numero de usuario</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
                <span class="help-block"><?php echo $telefono_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmar Contraseña</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
        </form>
    </div>    
</body>
</html>
