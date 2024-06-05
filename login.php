<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "paginafichar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger el DNI del formulario
    $dni = $_POST['dni'];
    $action = $_POST['action'];

    // Verificar si el usuario está registrado
    $stmt = $conn->prepare("SELECT id FROM user WHERE dni = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Usuario encontrado, obtener su id_user
        $stmt->bind_result($id_user);
        $stmt->fetch();
        $stmt->close();

        // Determinar si se está registrando entrada o salida
        if ($action == "entrada") {
            // Insertar la fecha y hora actual en la tabla "conectado" para entrada
            $entrada = date("Y-m-d H:i:s");
            $stmt = $conn->prepare("INSERT INTO conectado (id, entrada) VALUES (?, ?)");
            $stmt->bind_param("is", $id_user, $entrada);
        } else {
            // Actualizar la fecha y hora de salida en la tabla "conectado"
            $salida = date("Y-m-d H:i:s");
            $stmt = $conn->prepare("UPDATE conectado SET salida = ? WHERE id = ? AND salida IS NULL");
            $stmt->bind_param("si", $salida, $id_user);
        }

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            if ($action == "entrada") {
                echo "Registro de entrada exitoso";
            } else {
                echo "Registro de salida exitoso";
            }
        } else {
            echo "Error al registrar la " . ($action == "entrada" ? "entrada" : "salida") . ": " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "DNI no encontrado. Por favor, regístrese primero.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
<h1>INICIO DE SESIÓN</h1>
<form method="post" action="login.php">
    DNI: <input type="text" name="dni" required><br>
    <input type="submit" name="action" value="entrada" onclick="this.form.action='login.php?action=entrada'">
    <input type="submit" name="action" value="salida" onclick="this.form.action='login.php?action=salida'">
</form>
</body>
</html>
