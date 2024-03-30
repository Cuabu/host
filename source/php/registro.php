<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado todas las variables necesarias
    if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["emailRegister"]) && isset($_POST["passwordRegister"])) {
        // Obtener los datos del formulario
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["emailRegister"]; // Cambio aquí
        $password = $_POST["passwordRegister"]; // Cambio aquí

        // Configuración de la conexión a la base de datos
        $host = "localhost";
        $username = "root"; 
        $password_db = ""; 
        $database = "speed_store"; 

        // Crear conexión a la base de datos
        $conn = new mysqli($host, $username, $password_db, $database);

        // Verificacion de la conexión
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
?>
