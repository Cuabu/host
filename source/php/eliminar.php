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
    echo "<div class='message'>
            <h2>Mensaje de confirmación</h2>
            <p>Producto eliminado correctamente.</p>
            <a href='#' class='button' onclick='window.history.go(-1);'>Volver</a>
          </div>";
} else {
    echo "Error al eliminar el producto: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
