<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "speed_store";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener todos los productos
$sql = "SELECT * FROM producto";

// Ejecutar la consulta
$resultado = $conn->query($sql);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Imprimir los datos de cada producto
    while ($fila = $resultado->fetch_assoc()) {
        echo "ID del Producto: " . $fila["id_producto"] . "<br>";
        echo "Nombre: " . $fila["nombre"] . "<br>";
        echo "Descripción: " . $fila["descripcion"] . "<br>";
        echo "Precio: $" . $fila["precio"] . "<br>";
        echo "Imagen: <img src='data:image/jpeg;base64," . base64_encode($fila["imagen"]) . "' /> <br>"; // Asumiendo que la imagen se almacena como un blob en la base de datos
        echo "Fecha de Creación: " . $fila["fecha_creacion"] . "<br>";
        echo "--------------------------------------<br>";
    }
} else {
    echo "No se encontraron productos.";
}

// Cerrar la conexión
$conn->close();
