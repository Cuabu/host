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
        position: relative;
        overflow: hidden;
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
    /* Estilos para la imagen */
    .logo {
        display: block;
        margin: 0 auto;
        margin-bottom: 20px;
        width: 150px; /* Ajusta el tamaño de la imagen según sea necesario */
    }
    /* Animación de las letras */
    @keyframes move {
        0% {
            text-shadow: none;
            transform: translateX(0);
        }
        50% {
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            transform: translateX(5px);
        }
        100% {
            text-shadow: none;
            transform: translateX(0);
        }
    }
    .animated-text {
        display: inline-block;
        animation: move 1s infinite;
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
    echo "<img src='ruta/a/la/imagen.png' class='logo' alt='Logo'>"; // Agregar la ruta a tu imagen
    echo "<div class='message-container success'><span class='animated-text'>Inicio de sesión exitoso!</span></div>";
    // Redireccionar al dashboard después de 3 segundos
    echo '<script>
            setTimeout(function() {
                window.location.href = "../pages/dashboard.html";
            }, 1000);
          </script>';
} else {
    echo "<img src='ruta/a/la/imagen.png' class='logo' alt='Logo'>"; // Agregar la ruta a tu imagen
    echo "<div class='message-container error'><span class='animated-text'>Email o contraseña incorrectos.</span></div>";
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
