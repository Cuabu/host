<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "speed_store"; // Reemplaza "speed_store" con el nombre real de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
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
    echo "La tienda ya está registrada.";
} else {
    // Si el nombre de la tienda no existe, insertar los datos en la tabla "tienda"
    $sql = "INSERT INTO tienda (nombre, ubicacion, telefono) VALUES ('$nombre', '$ubicacion', '$telefono')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Tienda registrada correctamente.";
    } else {
        echo "Error al registrar la tienda: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
