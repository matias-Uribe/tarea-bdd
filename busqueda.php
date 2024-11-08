<?php

include("template/cabecera.php");

$nombre = (isset($_POST["buscar"])) ? $_POST["buscar"] : "";
$a=0;

if ($nombre != "") {
    $query = $conexion->prepare("SELECT * FROM `pelicula` WHERE nombrePelicula LIKE '%$nombre%'");
    $query->execute();
    $listaP = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<h1 style="text-align:center;"> Peliculas: </h1>

<?php
    foreach ($listaP as $pelicula) {
        include("template/caratula.php");

    }

    ?>
<h1 style="text-align:center;"> Usuarios: </h1>
<?php

    $query = $conexion->prepare("SELECT * FROM `usuario` WHERE nombreUsuario LIKE '%$nombre%'");
    $query->execute();
    $listaP = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listaP as $usuario) {
        $T = $usuario["nombreUsuario"];
        $I = $usuario["fotoUsuario"];
        $D = $usuario["descripcion"];
        $C = $usuario["idUsuario"];
        include("template/reseP.php");
    }
}



include("template/pie.php"); ?>