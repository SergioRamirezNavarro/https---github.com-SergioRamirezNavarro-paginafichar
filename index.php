<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "paginafichar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}
if (isset($_POST["dni"])) 
    {
        // Obtener valores del formulario
        $dni = $_POST['dni'];
        $pass = $_POST['pass'];

        // Consulta para verificar el DNI y la contraseña en la base de datos
        $sql = "SELECT * FROM user WHERE dni = '$dni' AND pass = '$pass'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Los datos son correctos
            echo "¡Datos válidos! Puedes iniciar sesión.";
        } else {
            // Los datos son incorrectos
            echo "Error: Datos inválidos. Por favor, intenta de nuevo.";
        }

        $conn->close();
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pagina para Fichar</title>
    <script>
        // Función para obtener y mostrar la fecha y hora actuales en tiempo real
        function mostrarFechaHora() {
            var fechaHoraActual = new Date();
            var fecha = fechaHoraActual.toLocaleDateString('es-ES');
            var hora = fechaHoraActual.toLocaleTimeString('es-ES');
            document.getElementById('fecha').innerHTML = "Fecha actual: " + fecha;
            document.getElementById('hora').innerHTML = "Hora actual: " + hora;
        }

        // Actualizar la fecha y hora cada segundo
        setInterval(mostrarFechaHora, 1000);
    </script>
</head>

<body>
    <hr>
    <!-- Mostrar fecha y hora actuales -->
    <div id="fechaHora">
        <span id="fecha"></span> | <span id="hora"></span>
    </div>
    <hr>

    <!-- Formulario para introducir DNI y contraseña -->
    <form action="home.php" method="post">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required> |
        <label for="pass">Contraseña:</label>
        <input type="pass" id="pass" name="pass" required> |
        <input type="submit" value="Validar">
    </form>
    <hr>

    <!-- Botones para redireccionar a las páginas de registro e inicio de sesión -->
    <button onclick="window.location.href='register.php'">Registrarse</button>
    <!-- <button onclick="window.location.href='login.php'">Iniciar Sesión</button> -->
    <hr>

    <!-- Tabla para mostrar registros -->
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Entrada/Salida</th>
            <th>Hora</th>

        </tr>
        <!-- Aquí se mostrarán los registros -->
    </table>

</body>

</html>