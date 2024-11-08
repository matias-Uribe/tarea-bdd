<?php

include("template/cabecera.php");

$query = $conexion->prepare("select * from pelicula");
$query->execute();
$listaP = $query->fetchAll(PDO::FETCH_ASSOC);
$a = 0;
foreach ($listaP as $pelicula) {
    include("template/caratula.php");

}







include("template/pie.php"); ?>