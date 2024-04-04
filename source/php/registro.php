<?php
session_start(); // Iniciar sesión

// Verificar si se recibieron los datos del formulario y si no están vacíos
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["emailRegister"]) && !empty($_POST["passwordRegister"])) {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["emailRegister"];
    $password = $_POST["passwordRegister"];

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
        // Mostrar un mensaje de registro exitoso con Bootstrap
        echo '
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="alert alert-success mt-3" role="alert">
                            ¡Registro exitoso! Serás redirigido en 1 segundo.
                        </div>
                    </div>
                </div>
            </div>';

        // Redireccionar a otra página después de un registro exitoso después de 3 segundos
        header("refresh:2;url=../pages/formulario.html");
        exit(); // Detener la ejecución del script después de redirigir
    } else {
        // Mostrar un mensaje de error si no se pueden registrar los datos
        echo "Error al registrar usuario: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Mostrar un mensaje si no se recibieron todos los datos del formulario o están vacíos
    echo '<div class="container">
              <div class="row justify-content-center">
                  <div class="col-md-6">
                      <div class="alert alert-danger mt-3" role="alert">
                          No se recibieron todos los datos del formulario o están vacíos.
                      </div>
                  </div>
              </div>
          </div>';
}
