<?php
// Inicializar o reanudar una sesión
session_start();

// Eliminar cualquier variable de sesión existente
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión u otra página deseada
header("Location: ../pages/index.html");
// Evitar que el navegador almacene en caché la página
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies. // Cambia "formulario.html" por la URL de tu página de inicio de sesión
exit();
