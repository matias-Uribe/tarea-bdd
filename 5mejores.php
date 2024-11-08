<?php

include("template/cabecera.php");
include("bdd/conexion.php");


$query = $conexion->prepare("SELECT * FROM pelicula ORDER BY puntuacion DESC LIMIT 5;");
$query->execute();
$listaP = $query->fetchAll(PDO::FETCH_ASSOC);
$a = 0;
foreach ($listaP as $pelicula) {
    include("template/caratula.php");

}

include("template/pie.php"); ?>