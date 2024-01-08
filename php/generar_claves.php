<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

$clavePrivada = openssl_pkey_new();
openssl_pkey_export($clavePrivada, $clavePrivadaString);

$informacionClave = openssl_pkey_get_details($clavePrivada);
$clavePublicaString = $informacionClave['key'];

$conexion = mysqli_connect('localhost', 'root', '', 'sistema_mensajeria');

$nombreUsuario = mysqli_real_escape_string($conexion, $nombreUsuario);
$clavePrivadaString = mysqli_real_escape_string($conexion, $clavePrivadaString);
$clavePublicaString = mysqli_real_escape_string($conexion, $clavePublicaString);

$query = "INSERT INTO usuarios (nombre, clave_privada, clave_publica) VALUES ('$nombreUsuario', '$clavePrivadaString', '$clavePublicaString')";
mysqli_query($conexion, $query);

mysqli_close($conexion);

echo "Claves generadas correctamente.";

$nombreArchivo = 'llavePublica_' . $nombreUsuario . '.key';
file_put_contents($nombreArchivo, $clavePublicaString);
?>
<h3>Se ha descargado la llave publica del usuario</h3>
<p>está en la ruta: C:\xampp\htdocs\examen\php</p>
<h1>Firmar mensaje</h1>
<a href="../formulario/firmar_mensaje.html">Ir a la página de firmar</a>
</body>
</html>


