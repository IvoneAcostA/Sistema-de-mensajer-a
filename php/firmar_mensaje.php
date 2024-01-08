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
$mensaje = $_POST['mensaje'];
$conexion = mysqli_connect('localhost', 'root', '', 'sistema_mensajeria');

$nombreUsuario = mysqli_real_escape_string($conexion, $nombreUsuario);
$mensaje = mysqli_real_escape_string($conexion, $mensaje);

$query = "SELECT clave_privada FROM usuarios WHERE nombre = '$nombreUsuario'";
$resultado = mysqli_query($conexion, $query);
$registro = mysqli_fetch_assoc($resultado);
$clavePrivadaString = $registro['clave_privada'];

$clavePrivada = openssl_pkey_get_private($clavePrivadaString);
openssl_sign($mensaje, $firma, $clavePrivada);

openssl_free_key($clavePrivada);

$firmaBase64 = base64_encode($firma);
$nombreArchivo = 'firma_digital_' . $nombreUsuario . '.txt';
file_put_contents($nombreArchivo, $firmaBase64);

mysqli_close($conexion);
?>

<h1>Se ha descargado la firma digital</h1>
<p>está en la ruta: C:\xampp\htdocs\examen\php</p>
<h1>Verificar firma</h1>
  <a href="../formulario/verificar_firma.html">Ir a la página de verificar</a>

<h3>Para verificar firmas de otros usuarios</h3>
<a href="../formulario/verificar_firma_otros_usuarios.html">Ir a la página de verificar a otros usuarios</a>
</body>
</html>