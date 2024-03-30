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
$email = $_POST['emailLogin'];
$password = $_POST['passwordLogin'];

// Prevenir ataques de inyección de SQL utilizando declaraciones preparadas
$stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<div class='message-container success'>Inicio de sesión exitoso!</div>";
    // Redireccionar al dashboard después de 3 segundos
    echo '<script>
            setTimeout(function() {
                window.location.href = "../pages/dashboard.html";
            }, 3000);
          </script>';
} else {
    echo "<div class='message-container error'>Email o contraseña incorrectos.</div>";
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
