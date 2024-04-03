<?php
// Función para generar un token de sesión único
function generarToken()
{
    return bin2hex(random_bytes(32)); // Genera un token aleatorio de 32 bytes y lo convierte a formato hexadecimal
}

// Si se ha enviado una solicitud para cerrar sesión, ejecutar el proceso de cierre de sesión
if (isset($_POST['cerrar_sesion'])) {
    // Eliminar la cookie de sesión
    setcookie('token', '', time() - 3600, "/");
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../php/cerrar_sesion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speed Store Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/images/icono.png" type="image/svg+xml">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Estilos para los mensajes */
        .message-container {
            float: right;
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
            width: 150px;
            /* Ajusta el tamaño de la imagen según sea necesario */
        }

        /* Estilos para los modales */
        .modal-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-title {
            margin: 0;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 15px;
            border-top: 1px solid #dee2e6;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /* Estilos para los botones de cierre en los modales */
        .close {
            color: #fff;
            opacity: 1;
        }

        .close:hover {
            opacity: 0.75;
        }

        /* Estilos para los formularios dentro de los modales */
        .modal-content form {
            margin-bottom: 0;
        }

        /* Estilos adicionales para los botones en los modales */
        .modal-content button[type="submit"] {
            width: 100%;
        }

        /* Estilos adicionales para los campos de entrada en los formularios */
        .modal-content input[type="text"],
        .modal-content input[type="file"] {
            width: calc(100% - 22px);
            /* Ajustar el ancho del campo de entrada */
            margin-bottom: 10px;
        }

        /* Estilos adicionales para los botones en los formularios */
        .modal-content button[type="submit"] {
            width: 100%;
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
    </style>
</head>



<body id="top">

    <!-- Mensaje de inicio de sesión -->
    <div class="message-container">
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
        $email = $_POST['emailLogin'];
        $password = $_POST['passwordLogin'];

        // Prevenir ataques de inyección de SQL utilizando declaraciones preparadas
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generar un token de sesión único para el usuario
            $token = generarToken();

            // Enviar el token al cliente (aquí lo estamos almacenando en una cookie)
            // Eliminar la cookie de sesión
            setcookie('token', '', time() - 3600, "/");


            echo "<img src='ruta/a/la/imagen.png' class='logo' alt='Logo'>";
            echo "<div class='message-container success'><span class='animated-text'>Inicio de sesión exitoso!</span></div>";
            // Mostrar el botón para cerrar sesión
            echo "<form method='post'><button type='submit' name='cerrar_sesion' class='btn btn-primary'>Cerrar sesión</button></form>";
            // Redireccionar al dashboard después de 2 horas y 46 minutos
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "../pages/login.php";
                    }, 1200000); // 
                  </script>';
        } else {
            echo "<img src='ruta/a/la/imagen.png' class='logo' alt='Logo'>";
            echo "<div class='message-container error'><span class='animated-text'>Iniciar Sesion Nuevamente.</span></div>";
        }

        // Cerrar la conexión a la base de datos
        $stmt->close();
        $conn->close();
        ?>

    </div>


    <!-- Barra lateral con menú desplegable -->
    <div class="sidebar">
        <div class="container mt-5">
            <div class="row">
                <div class="col-sm-12">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Operaciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#modalConsultar">Consultar Producto</button>
                            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#modalInsercion">Agregar Producto</button>
                            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#modalModificar">Modificar Producto</button>
                            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#modalEliminar">Eliminar Producto</button>
                            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#modalRegistro">Registrar Tienda</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ventanas Modales -->
    <!-- Ventana modal para el formulario de consulta -->
    <div class="modal fade" id="modalConsultar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consultar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de consulta -->
                    <form id="formularioConsulta" action="../php/consulta.php" method="post">
                        <div class="form-group">
                            <label for="codigoConsulta">Nombre del Producto:</label>
                            <input type="text" class="form-control" id="codigoConsulta" name="codigoConsulta" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Consultar por nombre</button>
                    </form>

                    <form id="formularioMisProductos" action="../php/mis_productos.php" method="post">
                        <div class="form-group"></div>
                        <button type="submit" class="btn btn-primary">Consultar mis productos</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana modal para el formulario de inserción -->
    <div class="modal fade" id="modalInsercion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de inserción -->
                    <form id="formularioInsercion" action="../php/insertar.php" method="post">

                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="text" class="form-control" id="precio" name="precio" required>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen:</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana modal para modificar registro -->
    <div class="modal fade" id="modalModificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Formulario de modificación -->
                    <form id="formularioModificacion" action="../php/modificar.php" method="post">

                        <div class="form-group">
                            <label for="nombreModificar">Nuevo Nombre:</label>
                            <input type="text" class="form-control" id="nombreModificar" name="nombreModificar" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcionModificar">Nueva Descripción:</label>
                            <input type="text" class="form-control" id="descripcionModificar" name="descripcionModificar" required>
                        </div>

                        <div class="form-group">
                            <label for="precioModificar">Nuevo Precio:</label>
                            <input type="text" class="form-control" id="precioModificar" name="precioModificar" required>
                            <input type="hidden" id="codigoHidden" name="codigoHidden">
                        </div>

                        <div class="form-group">
                            <label for="codigoModificar">Código del Producto:</label>
                            <input type="text" class="form-control" id="codigoModificar" name="codigoModificar" required>
                            <input type="hidden" id="codigoHidden" name="codigoHidden">
                        </div>

                        <div class="form-group">
                            <label for="imagen">Imagen:</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana modal para eliminar registro -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de eliminación -->
                    <form id="formularioEliminar" action="../php/eliminar.php" method="post">
                        <div class="form-group">
                            <label for="id_producto">ID del Producto a Eliminar:</label>
                            <input type="text" class="form-control" id="id_producto" name="id_producto" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana modal para el formulario de inserción -->
    <div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Tienda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de inserción Tienda -->
                    <form id="formularioRegistro" action="../php/registro_tienda.php" method="post">
                        <div class="form-group">
                            <label for="codigo">Nombre Tienda</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Ubicacion Tienda:</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Telefono Tienda:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>



                <!-- Scripts -->
                <!-- Verificación de autenticación y script JavaScript para evitar retroceso -->
                <script>
                    // Deshabilitar el botón de retroceso del navegador después de cerrar sesión
                    window.history.pushState(null, document.title, window.location.href);
                    window.addEventListener('popstate', function(event) {
                        window.history.pushState(null, document.title, window.location.href);
                    });
                </script>

                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>