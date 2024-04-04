function limpiarCacheYCerrarSesion() {
    // Limpiar la caché del navegador
    if (caches) {
        caches.keys().then(function (names) {
            for (let name of names) caches.delete(name);
        });
    }

    // Eliminar tokens de autenticación (ejemplo: cookie)
    document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    // Redirigir a la página de inicio de sesión
    window.location.href = "../pages/login.php";
}
