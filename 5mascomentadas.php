<?php

include("template/cabecera.php");
include("bdd/conexion.php");


$query = $conexion->prepare("SELECT * FROM `vw_top5` LIMIT 5");
$query->execute();
$listaP = $query->fetchAll(PDO::FETCH_ASSOC);
$a = 1;
foreach ($listaP as $pelicula) {
    include("template/caratula.php");

}

include("template/pie.php"); ?>

<!-- CREATE VIEW VW_top5 AS
SELECT pelicula.idPelicula,MAX(nombrePelicula) AS nombrePelicula,MAX(fotoPelicula) as fotoPelicula,MAX(descripcion) as descripcion,MAX(pelicula.puntuacion) as puntuacion ,COUNT(pelicula.idPelicula) as nrese
FROM pelicula 
INNER JOIN reseña
ON pelicula.idPelicula=reseña.idPelicula GROUP BY pelicula.idPelicula ORDER BY nrese DESC LIMIT 5; -->