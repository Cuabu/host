<?php
echo "<style>
    /* Estilos CSS */

    /* Estilos para el mensaje */
    .message {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 20vh auto;
        padding: 20px;
        background-color: #f0f0f0;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 80%;
    }

    .message h2 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .message p {
        color: #666;
        font-size: 18px;
        margin-bottom: 15px;
    }

    .button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #0056b3;
    }
</style>";

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
    $sql = "SELECT * FROM producto WHERE id_producto = '$codigoConsulta'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los datos del producto
        while ($row = $result->fetch_assoc()) {
            echo "<div class='message'>
                <h2>Datos del Producto</h2>
                <p>ID del Producto: " . $row["id_producto"] . "</p>
                <p>Nombre: " . $row["nombre"] . "</p>
                <p>Descripción: " . $row["descripcion"] . "</p>
                <p>Precio: $" . $row["precio"] . "</p>
                </div>";
        }
    } else {
        echo "<div class='message'>
                <h2>Mensaje de Error</h2>
                <p>No se encontró ningún producto con ese código.</p>
                </div>";
    }
} else {
    echo "<div class='message'>
            <h2>Mensaje de Error</h2>
            <p>No se proporcionó ningún código de producto.</p>
            </div>";
}

// Cerrar la conexión
$conn->close();
