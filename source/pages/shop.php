<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "speed_store";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
	die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para seleccionar todos los datos de la tabla "productos"
$sql = "SELECT id, nombre, descripcion FROM productos";
$result = $conn->query($sql);

// Verificar si hay resultados y mostrarlos en una tabla HTML
if ($result->num_rows > 0) {
	echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>";
	// Mostrar cada fila de datos
	while ($row = $result->fetch_assoc()) {
		echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["nombre"] . "</td>
                <td>" . $row["descripcion"] . "</td>
            </tr>";
	}
	echo "</table>";
} else {
	echo "No se encontraron resultados.";
}
// Cerrar la conexión
$conn->close();
