<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Firma</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/inicio.css">
</head>
<body>
<header>
    <h1>Tech Market</h1>
    <nav>
        <ul>
            <li><a href="../show.html">Inicio</a></li>
        </ul>
    </nav>
</header>
<?php
$nombreUsuario = $_POST['nombre'];
$mensaje = $_POST['mensaje'];
$firma = $_POST['firmaContenido']; 

$conexion = mysqli_connect('localhost', 'root', '', 'sistema_mensajeria');
$nombreUsuario = mysqli_real_escape_string($conexion, $nombreUsuario);
$mensaje = mysqli_real_escape_string($conexion, $mensaje);

$query = "SELECT clave_publica FROM usuarios WHERE nombre = '$nombreUsuario'";
$resultado = mysqli_query($conexion, $query);
$registro = mysqli_fetch_assoc($resultado);
$clavePublicaString = $registro['clave_publica'];

$clavePublica = openssl_pkey_get_public($clavePublicaString);

$verificacion = openssl_verify($mensaje, base64_decode($firma), $clavePublica);

openssl_free_key($clavePublica);

if ($verificacion === 1) {
    echo "Firma es válida";
} else {
    echo "La firma no es válida";
}

mysqli_close($conexion);
?>
</body>
</html>



</body>
</html>
