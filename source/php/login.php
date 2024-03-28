<?php
// Configuración de la base de datos
$host = "localhost"; // Cambia al host de tu base de datos
$username = "root"; // Cambia al nombre de usuario de tu base de datos
$password = ""; // Cambia a la contraseña de tu base de datos
$dbname = "speed_store"; // Cambia al nombre de tu base de datos

// Crear una conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el email y la contraseña del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta SQL para verificar el email y la contraseña
$sql = "SELECT * FROM usuario WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Inicio de sesión exitoso!";
    // Redireccionar al dashboard después de 3 segundos
    echo '<script>
            setTimeout(function() {
                window.location.href = "../pages/dashboard.html";
            }, 3000);
          </script>';
} else {
    echo "Email o contraseña incorrectos.";
}

// Cerrar la conexión a la base de datos
$conn->close();
