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
    <title>Speed Store Mi Perfil</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/images/icono.png" type="image/svg+xml">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="../pages/css/style2.css" rel="stylesheet">

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
            // Obtener los datos del usuario
            $row = $result->fetch_assoc();
            $nombreUsuario = $row['nombre'];
            $apellidoUsuario = $row['apellido'];

            // Generar un token de sesión único para el usuario
            $token = generarToken();

            // Enviar el token al cliente (aquí lo estamos almacenando en una cookie)
            // Eliminar la cookie de sesión
            setcookie('token', '', time() - 3600, "/");


            echo "<img src='../pages/images/person-1.png' class='logo' alt='Logo'>";
            echo "<div class='message-container success'><span class='animated-text'>Bienvenido! $nombreUsuario $apellidoUsuario </span></div>";
            // Mostrar el botón para cerrar sesión
            echo "<form method='post'><button type='submit' name='cerrar_sesion' class='btn btn-primary'>Cerrar sesión</button></form>";
            // Redireccionar al dashboard después de 2 horas y 46 minutos
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "../pages/login.php";
                    }, 1200000); 
                  </script>';
        } else {
            echo "<img src='ruta/a/la/imagen.png' class='logo' alt='Logo'>";
            echo '<script>
            window.location.href = "../pages/fail.html";
                  </script>';
        }

        // Cerrar la conexión a la base de datos
        $stmt->close();
        $conn->close();
        ?>

    </div>

    <!-- inicio Header/Nav -->
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Speed navigation bar">
        <div class="container">
            <a class="navbar-brand" href="index.html">Speed Store<span>.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>
    <!-- Fin del Header/Nav -->


    <body>

        <div class="container mt-5">
            <div class="row">
                <!-- Botones para abrir las ventanas modales -->
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalConsultar">
                        Consultar Datos
                    </button>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalInsercion">
                        Insertar Datos
                    </button>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalModificar">
                        Modificar Datos
                    </button>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalEliminar">
                        Eliminar Datos
                    </button>
                </div>
            </div>
        </div>

        <!-- Ventana modal para el formulario de consulta -->
        <div class="modal fade" id="modalConsultar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Consultar Datos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de consulta -->
                        <form id="formularioConsulta" action="consulta.php" method="post">
                            <div class="form-group">
                                <label for="codigoConsulta">Código del producto:</label>
                                <input type="text" class="form-control" id="codigoConsulta" name="codigoConsulta" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Consultar</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Ventana modal para el formulario de inserción -->
        <div class="modal fade" id="modalInsercion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Insertar Datos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de inserción -->
                        <form id="formularioInsercion" action="insertar.php" method="post">
                            <div class="form-group">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" required>
                            </div>
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
                            <button type="submit" class="btn btn-primary">Insertar</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">Modificar Datos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <!-- Formulario de modificación -->
                        <form id="formularioModificacion" action="modificar.php" method="post">

                            <div class="form-group">
                                <label for="nombreModificar">Nuevo Nombre:</label>
                                <input type="text" class="form-control" id="nombreModificar" name="nombreModificar" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcionModificar">Nueva Descripción:</label>
                                <input type="text" class="form-control" id="descripcionModificar" name="descripcionModificar" required>
                            </div>

                            <div class="form-group">
                                <label for="codigoModificar">Nuevo Precio:</label>
                                <input type="text" class="form-control" id="precioModificar" name="precioModificar" required>
                                <input type="hidden" id="codigoHidden" name="codigoHidden">
                            </div>

                            <div class="form-group">
                                <label for="codigoModificar">Código del Producto:</label>
                                <input type="text" class="form-control" id="codigoModificar" name="codigoModificar" required>
                                <input type="hidden" id="codigoHidden" name="codigoHidden">
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
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Datos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de eliminación -->
                        <form id="formularioEliminar" action="eliminar.php" method="post">
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


        <!-- Modal para editar producto -->
        <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarLabel">Editar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí puedes colocar el formulario de edición de producto -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asegúrate de incluir los scripts de jQuery y Bootstrap al final de tu página -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                // Agrega un evento de clic a los botones "Ver imagen"
                $('.ver-imagen').on('click', function() {
                    // Obtiene la ruta de la imagen temporal desde el atributo data-imagen del botón
                    var imagenTemporal = $(this).data('imagen');

                    // Crea una ventana emergente y establece su contenido como la imagen temporal
                    var ventanaEmergente = window.open('');
                    ventanaEmergente.document.write('<img src="' + imagenTemporal + '" />');
                });

                // Agrega un evento de clic al botón "Editar"
                $('.editar').on('click', function() {
                    // Obtiene los datos del producto desde los atributos data del botón
                    var idProducto = $(this).data('id');
                    var nombreProducto = $(this).data('nombre');
                    var descripcionProducto = $(this).data('descripcion');
                    var precioProducto = $(this).data('precio');

                    // Llena el formulario modal con los datos del producto
                    $('#modalEditar').modal('show');
                    // Aquí puedes completar el código para llenar el formulario modal con los datos del producto
                });

                // Agrega un evento de clic al botón "Eliminar"
                $('.eliminar').on('click', function() {
                    // Obtiene el ID del producto a eliminar desde el atributo data del botón
                    var idProducto = $(this).data('id');
                    // Aquí puedes completar el código para ejecutar la acción de eliminación del producto
                });

                // Agrega un evento de clic al botón "Agregar"
                $('.agregar').on('click', function() {
                    // Aquí puedes completar el código para ejecutar la acción de agregar un nuevo producto
                });
            });
        </script>

        </tbody>
        </table>
    </body>

    <!--footer aqui-->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">© 2024 Speed Store. Todos los derechos reservados.</span>
        </div>
    </footer>


    <!-- Scripts -->
    <!-- Verificación de autenticación y script JavaScript para evitar retroceso -->
    <script src="../pages/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Deshabilitar el botón de retroceso del navegador después de cerrar sesión
        window.history.pushState(null, document.title, window.location.href);
        window.addEventListener('popstate', function(event) {
            window.history.pushState(null, document.title, window.location.href);
        });
    </script>


</body>

</html>