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
        // Obtener el DNI enviado desde el formulario
        $dni = $_POST['dni'];

        // Consulta para obtener el nombre asociado al DNI
        $sql = "SELECT nombre FROM user WHERE dni = '$dni'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
            {
                // Si se encontró un usuario con el DNI proporcionado, obtener su nombre
                $row = $result->fetch_assoc();
                $nombre = $row['nombre'];
            } else 
                {
                    // Si no se encontró ningún usuario con el DNI proporcionado, establecer el nombre como vacío
                    $nombre = "";
                }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
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

    <!-- Mensaje de bienvenida y botones de entrada y salida -->
    <div>
        <?php
        // Verificar si el nombre de usuario está definido y no está vacío
        if (isset($nombre) && !empty($nombre)) {
            echo "Hola, $nombre"; // Mostrar el nombre del usuario
        } else {
            echo "Hola, Usuario"; // Mostrar un mensaje predeterminado si el nombre de usuario no está disponible
        }
        ?> <!-- Aquí se mostrará el nombre de usuario conectado si está definido -->
        <button>Entrada</button> <!-- Botón de entrada -->
        <button>Salida</button> <!-- Botón de salida -->
    </div>
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