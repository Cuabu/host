<?php
// Conexión a la base de datos
$host = "localhost";
$username = "root"; // Cambiar al nombre de usuario de tu base de datos
$password = ""; // Cambiar a la contraseña de tu base de datos
$dbname = "speed_store"; // Cambiar al nombre de tu base de datos

// Crear conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar: " . $conn->connect_error);
}

// Obtener los datos del formulario
$id_producto = $_POST['id_producto']; // Producto que viene desde el formulario HTML

// Consulta SQL para eliminar el producto
$sql = "DELETE FROM producto WHERE id_producto = $id_producto";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Producto eliminado correctamente.";
} else {
    echo "Error al eliminar el producto: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
