<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado todas las variables necesarias
    if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["email"]) && isset($_POST["password"])) {
        // Obtener los datos del formulario
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Configuración de la conexión a la base de datos
        $host = "localhost";
        $username = "root"; // Cambiar al nombre de usuario de tu base de datos
        $password_db = ""; // Cambiar a la contraseña de tu base de datos
        $database = "speed_store"; // Cambiar al nombre de tu base de datos

        // Crear conexión a la base de datos
        $conn = new mysqli($host, $username, $password_db, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta SQL para insertar un nuevo usuario en la tabla "usuario"
        $sql = "INSERT INTO usuario (nombre, apellido, email, password) VALUES ('$nombre', '$apellido', '$email', '$password')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo "Registro de usuario exitoso!";
        } else {
            echo "Error al registrar usuario: " . $conn->error;
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo "No se recibieron todos los datos del formulario.";
    }
}
