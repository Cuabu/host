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
    echo "<div class='message-container success'>Producto actualizado correctamente.</div>";
} else {
    echo "<div class='message-container error'>Error al actualizar el producto: " . mysqli_error($conn) . "</div>";
}

// Cerrar la conexión
mysqli_close($conn);
