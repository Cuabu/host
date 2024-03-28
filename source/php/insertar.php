<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "speed_store";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['tmp_name']; // Nombre temporal del archivo
    $fecha_creacion = date("Y-m-d"); // Obtener la fecha actual

    // Preparar la consulta SQL para insertar un nuevo producto
    $stmt = $conn->prepare("INSERT INTO producto (nombre, descripcion, precio, imagen, fecha_creacion) VALUES (?, ?, ?, ?, ?)");

    // Vincular parámetros
    $stmt->bind_param("ssdbs", $nombre, $descripcion, $precio, $imagen, $fecha_creacion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Producto registrado correctamente
        echo "<script>alert('Producto registrado correctamente.');window.history.go(-1);</script>";
    } else {
        // Error al registrar el producto
        echo "Error al registrar el producto: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
