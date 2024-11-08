<?php

include("template/cabecera.php");
include("bdd/conexion.php");





$query = $conexion->prepare("SELECT * FROM `pelicula` WHERE F_disponibles(idPelicula)<5 and F_disponibles(idPelicula)>0;");
$query->execute();
$listaP = $query->fetchAll(PDO::FETCH_ASSOC);

$a = 2;
foreach ($listaP as $pelicula) {
    include("template/caratula.php");

}

include("template/pie.php"); ?>