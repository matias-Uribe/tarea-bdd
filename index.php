<?php include("template/cabecera.php"); ?>
<div class="jumbotron">
    <img class="card-img-right" src="img/logo.png" alt="" height="180" href="perfil.php">
    <h1 class="display-3">Bienvenidos a Blockbusm:
        <?php echo $nombreUsuario ?>
    </h1>
</div>


<?php
$query = $conexion->prepare("CALL P_V($IDUSUARIO);");
$query->execute();
$listaSeguidos = $query->fetchAll(PDO::FETCH_ASSOC);
if (!empty($listaSeguidos[0]["idUsuario"])) {
    foreach ($listaSeguidos as $reseñas) {
        $ids = $reseñas["idUsuario"];
        $des = $reseñas["descripcionReseña"];
        $idp = $reseñas["idPelicula"];
        $fecha = $reseñas["fecha"];
        $pun = $reseñas["puntuacion"];
        if ($pun > 5) {
            $pun = "";
        }
        $query = $conexion->prepare("SELECT fotoPelicula, nombrePelicula  FROM pelicula WHERE idPelicula='$idp' ;");
        $query->execute();
        $listaP = $query->fetchAll(PDO::FETCH_ASSOC);
        $fotoP = $listaP[0]["fotoPelicula"];
        $np = $listaP[0]["nombrePelicula"];

        $query = $conexion->prepare("SELECT fotoUsuario , nombreUsuario FROM usuario WHERE idUsuario='$ids' ;");
        $query->execute();
        $listaP = $query->fetchAll(PDO::FETCH_ASSOC);
        $fotoS = $listaP[0]["fotoUsuario"];
        $ns = $listaP[0]["nombreUsuario"];


?>
<div class="card text-white bg-secondary mb-3" style="max-width: 80rem;">
    <div class="row">
        <div class="col-md-2">
            <div class="card-body">
                <form method="POST" ACTION="otroperfil.php">
                    <button type="submit" name="eleccion" value="<?php echo $ids ?>" class="btn btn-secondary">
                        <img class="card-img-top" src="img/<?php echo $fotoS; ?>" height="150">
                    </button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-2">
                    Nombre:
                    </br>
                    <?php echo $ns; ?>
                </div>
                <div class="col-md-2">
                    Fecha</br>
                    <?php echo $fecha; ?>
                </div>
                <div class="col-md-2">
                    Puntuacion:
                    <strong>
                        <?php echo $pun; ?>
                    </strong>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <?php echo $des; ?>
                </p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card-body">
                <h5 style="text-align:center">
                    <?php echo $np ?>
    </h5>
                <form method="POST" ACTION="mostrarpeli.php">
                    <button type="submit" name="eleccion" value="<?php echo $idp ?>" class="btn btn-secondary">
                        <img class="card-img-top" src="img/<?php echo $fotoP; ?>" height="150">
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php }
}
include("template/pie.php"); ?>