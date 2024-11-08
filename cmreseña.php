<?php
include("template/cabecera.php");

$id = (isset($_POST["reseña"])) ? $_POST["reseña"] : "";
$query = $conexion->prepare("SELECT * FROM `pelicula` WHERE idPelicula='$id';");
$query->execute();
$listaP = $query->fetchAll(PDO::FETCH_ASSOC);
$nombre = $listaP[0]["nombrePelicula"];
$query = $conexion->prepare("SELECT * FROM `reseña` WHERE idPelicula='$id' and idUsuario='$IDUSUARIO';");
$query->execute();
$listaR = $query->fetchAll(PDO::FETCH_ASSOC);
if (!empty($listaR[0]["descripcionReseña"])) {
    $D = $listaR[0]["descripcionReseña"];
} else {
    $D = "";
}


?>



<div class="card">
    <div class="card-header">
        <h1 style="text-align:center;"> RESEÑA :
            <?php echo $nombre ?>
        </h1>
    </div>
    <div class="card-body">
        <form method="POST" ACTION="mostrarpeli.php">
            <div class="form-group">
                <label for="exampleTextarea" class="form-label mt-4">Descripcion de la Reseña:</label>
                <textarea class="form-control" name="exampleTextarea" rows="3"><?php echo $D; ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="exampleSelect1" class="form-label mt-4">Calificacion</label>
                    <select class="form-select" name="exampleSelect1">
                        <option></option>
                        <option>0</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-1">
                    </br>
                    </br>
                    <button type="submit" name="guardar" value="<?php echo $id ?>"
                        class="btn btn-primary">Guardar</button>

                </div>
                <div class="col-md-1 ">
                    </br>
                    </br>
                    <button type="submit" name="cancelar" value="<?php echo $id ?>"
                        class="btn btn-info">Cancelar</button>
                </div>
                <div class="col-md-1">
                    </br>
                    </br>
                    <button type="submit" name="eliminar2" value="<?php echo $id ?>"
                        class="btn btn-danger">Eliminar</button>
                </div>



            </div>
        </form>
    </div>
</div>


<?php
include("template/pie.php")
    ?>