<?php
echo "<style>
    /* Estilos CSS */

    /* Estilos para la tabla de productos */
    table {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 80%;
        margin: 20px auto;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Estilos para el contenedor de la tabla */
    .container {
        text-align: center;
        margin-top: 50px;
    }
</style>";

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
            <table>
                <tr>
                    <th>ID del Producto</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Fecha de Creación</th>
                </tr>";

    // Imprimir los datos de cada producto en filas de la tabla
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>" . $fila["id_producto"] . "</td>
                <td>" . $fila["nombre"] . "</td>
                <td>" . $fila["descripcion"] . "</td>
                <td>$" . $fila["precio"] . "</td>
                <td><img src='data:image/jpeg;base64," . base64_encode($fila["imagen"]) . "' style='max-width: 500px;' /></td>
                <td>" . $fila["fecha_creacion"] . "</td>
            </tr>";
    }
    echo "</table></div>";
} else {
    echo "<div class='container'>
            <p>No se encontraron productos.</p>
          </div>";
}

// Cerrar la conexión
$conn->close();
