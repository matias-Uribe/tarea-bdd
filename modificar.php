<?php
include("template/cabecera.php");


?>

<div class="card">
    <div class="card-header">
        <h1 style="text-align:center;"> CONFIGURACIONES: </h1>
    </div>
    <div class="card-body">
        <form class="form-group" method="POST" ACTION="perfil.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <label>Nombre usuario</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Escribe tu Usuario"
                            value="<?php echo $nombreUsuario ?>">
                        <label>Contraseña</label>
                        <input type="text" class="form-control" name="contraseña" placeholder="Escribe tu Contraseña"
                            value="<?php echo $CONTRASEÑA ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <label>Correo</label>
                        <input type="text" class="form-control" name="correo" placeholder="Escribe tu Correo"
                            value="<?php echo $CORREO ?>">
                        <label>Imagen:
                            <?php echo $FOTOUSUARIO ?>
                        </label>
                        <input type="file" class="form-control" name="txtImagen" id="txtImagen">
                    </div>
                </div>
            </div>

            <div>
                <label for="exampleTextarea" class="form-label mt-4">Descripcion de la Reseña:</label>
                <textarea class="form-control" name="exampleTextarea" rows="3"><?php echo $DESCRIPCION ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-1">
                    </br>
                    </br>
                    <button type="submit" name="accion" value="guardar" class="btn btn-primary">Guardar</button>

                </div>
                <div class="col-md-1 ">
                    </br>
                    </br>
                    <button type="submit" name="accion" value="cancelar" class="btn btn-info">Cancelar</button>
                </div>
                <div class="col-md-1">
                    </br>
                    </br>
                    <button type="submit" name="accion" value="eliminar" class="btn btn-danger">Eliminar</button>
                </div>



            </div>
        </form>
    </div>
</div>
















<?php
include("template/pie.php")
    ?>