<?php

if (file_exists('.env.ini')) {
  $env = parse_ini_file('.env.ini', true);
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$servername = "localhost";
$username = "root";
$password = isset($env) ? $env['DB_PASSWORD'] : "";
$db = "sitmdm";

try {
  $conexiones = new PDO("mysql:host=$servername;dbname=$db", $username, $password, array('charset' => 'utf8'));
  $conexiones->query("SET CHARACTER SET utf8");
  //setear el modo de error de PDO a exception
  $conexiones->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbStatus = "Exitosa";
} catch (PDOException $e) {
  $dbStatus = "Fallo la conexion: " . utf8_encode($e->getMessage());
}

$mysqli = new mysqli($servername, $username, $password, $db);
if ($mysqli->connect_errno) {
  echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
}


$conexion = mysqli_connect($servername, $username, $password, $db) or
  die("Problemas con la conexión");