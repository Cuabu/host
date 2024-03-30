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
        echo "<div class='message'>
                <h2>Mensaje de confirmación</h2>
                <p>Producto registrado correctamente.</p>
                <a href='#' class='button' onclick='window.history.go(-1);'>Volver</a>
              </div>";
    } else {
        // Error al registrar el producto
        echo "Error al registrar el producto: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
