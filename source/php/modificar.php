<?php
// Conexión a la base de datos
$host = "localhost";
$username = "root"; // Cambiar al nombre de usuario de tu base de datos
$password = ""; // Cambiar a la contraseña de tu base de datos
$dbname = "speed_store"; // Cambiar al nombre de tu base de datos

// Crear conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Error al conectar: " . mysqli_connect_error());
}

// Obtener los datos del formulario
$codigo = $_POST['codigoModificar'];
$nombre = $_POST['nombreModificar'];
$descripcion = $_POST['descripcionModificar'];
$precio = $_POST['precioModificar'];
$imagen = $_POST['imagen'];

// Consulta SQL para actualizar el producto
$sql = "UPDATE producto SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen' WHERE id_producto='$codigo'";

// Ejecutar la consulta
if (mysqli_query($conn, $sql)) {
    echo "Producto actualizado correctamente.";
} else {
    echo "Error al actualizar el producto: " . mysqli_error($conn);
}

// Cerrar la conexión
mysqli_close($conn);
