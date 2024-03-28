<?php
// Datos de conexión a la base de datos
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

// Verificar si se recibió un código de producto
if (isset($_POST['codigoConsulta'])) {
    // Limpiar y obtener el código de producto
    $codigoConsulta = $conn->real_escape_string($_POST['codigoConsulta']);

    // Consulta SQL para seleccionar el producto por su código
    $sql = "SELECT * FROM producto WHERE nombre = '$codigoConsulta'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los datos del producto
        while ($row = $result->fetch_assoc()) {
            echo "ID del Producto: " . $row["id_producto"] . "<br>";
            echo "Nombre: " . $row["nombre"] . "<br>";
            echo "Descripción: " . $row["descripcion"] . "<br>";
            echo "Precio: $" . $row["precio"] . "<br>";
            // Aquí puedes mostrar la imagen si lo deseas
        }
    } else {
        echo "No se encontró ningún producto con ese código.";
    }
} else {
    echo "No se proporcionó ningún código de producto.";
}

// Cerrar la conexión
$conn->close();
