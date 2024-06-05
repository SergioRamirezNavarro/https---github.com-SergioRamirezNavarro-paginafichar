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
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);  // Hashear la contraseña

    // Preparar la sentencia SQL para insertar los datos
    $stmt = $conn->prepare("INSERT INTO user (nombre, dni, pass) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $dni, $pass);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Nuevo usuario registrado con éxito";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
<h1>REGISTER</h1>
<form method="post" action="register.php">
    nombre: <input type="text" name="nombre" required><br>
    dni: <input type="text" name="dni" required><br>
    pass: <input type="password" name="pass" required><br>
    <input type="submit" value="Registrar">
</form>
</body>
</html>
