<?php
echo "<style>
    /* Estilos para los mensajes */
    .message-container {
        width: 50%;
        margin: 0 auto;
        text-align: center;
        margin-top: 50px;
        padding: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        color: #212529;
    }
    .message-container.success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    .message-container.error {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
</style>";

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "speed_store"; // Reemplaza "speed_store" con el nombre real de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("<div class='message-container error'>Error de conexión: " . $conn->connect_error . "</div>");
}

// Obtener los datos del formulario (suponiendo que los datos se envían por POST)
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$telefono = $_POST['telefono'];

// Consulta SQL para verificar si el nombre de la tienda ya existe
$consulta_existencia = "SELECT nombre FROM tienda WHERE nombre = '$nombre'";
$resultado_existencia = $conn->query($consulta_existencia);

if ($resultado_existencia->num_rows > 0) {
    // Si el nombre de la tienda ya existe, mostrar un mensaje
    echo "<div class='message-container error'>La tienda ya está registrada.</div>";
} else {
    // Si el nombre de la tienda no existe, insertar los datos en la tabla "tienda"
    $sql = "INSERT INTO tienda (nombre, ubicacion, telefono) VALUES ('$nombre', '$ubicacion', '$telefono')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "<div class='message-container success'>Tienda registrada correctamente.</div>";
    } else {
        echo "<div class='message-container error'>Error al registrar la tienda: " . $conn->error . "</div>";
    }
}

// Cerrar la conexión
$conn->close();
