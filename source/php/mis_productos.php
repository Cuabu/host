<!-- En el encabezado de tu página, asegúrate de incluir la referencia a Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "speed_store";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener todos los productos
$sql = "SELECT * FROM producto";

// Ejecutar la consulta
$resultado = $conn->query($sql);

// Verificar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    echo "<div class='container'>
            <table class='table'>
                <thead>
                    <tr>
                        <th>ID del Producto</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Ver imagen</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>";

    // Imprimir los datos de cada producto en filas de la tabla
    while ($fila = $resultado->fetch_assoc()) {
        // Descargar la imagen de forma temporal
        $imagenTemporal = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($imagenTemporal, base64_decode($fila["imagen"]));

        echo "<tr>
                <td>" . $fila["id_producto"] . "</td>
                <td>" . $fila["nombre"] . "</td>
                <td>" . $fila["descripcion"] . "</td>
                <td>$" . $fila["precio"] . "</td>
                <td>
                    <button class='btn btn-primary ver-imagen' data-imagen='" . $imagenTemporal . "'>Ver imagen</button>
                </td>
                <td>" . $fila["fecha_creacion"] . "</td>
                <td>
                    <button class='btn btn-warning editar' data-id='" . $fila["id_producto"] . "' data-nombre='" . $fila["nombre"] . "' data-descripcion='" . $fila["descripcion"] . "' data-precio='" . $fila["precio"] . "'>Editar</button>
                    <button class='btn btn-danger eliminar' data-id='" . $fila["id_producto"] . "'>Eliminar</button>
                    <button class='btn btn-success agregar'>Agregar</button>
                </td>
            </tr>";
    }
    echo "</tbody></table></div>";
} else {
    echo "<div class='container'>
            <p>No se encontraron productos.</p>
          </div>";
}

// Cerrar la conexión
$conn->close();
?>

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