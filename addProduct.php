<?php
session_start();

$page = 'products';
if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '' ) {
} else {
    echo "Usuario no Autorizado";
    exit();
}
if ($_SESSION['current_rol'] =='admin') {

}else{
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}
include 'model/TipoProducto.php';
$objTipoProducto = new TipoProducto();
$listaTipoProductos = $objTipoProducto->getTipoProductos();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.::Dashboard::.</title>
    <?php include 'layout/library.php' ?>
    <link rel="stylesheet" href="library/css/dropify.min.css">
</head>
<body>

<?php include 'layout/userNavBar.php' ?>
<div class="container">

    <div class="row">
        <div class="row" style="margin-top: 20px;">
            <div class="col l12 s12 m12 xl12 center-align">
                <h5>Insertar Nuevo Producto</h5>
            </div>
        </div>
        <div class="col l6 push-l3 pull-l3 s12 center-align z-depth-4 hoverable"
             style="border-radius:5px;border: 2px solid black;margin-top: 20px;padding: 50px;margin-bottom: 40px">
            <form class="col s12" action="https://cevicheriarichards.com/script/addProduct.php" enctype="multipart/form-data" method="post">

                <div class="row">
                    <div class="input-field col s12">
                        <input data-min-height="499" data-max-file-size="2M" data-min-width="499" required
                               data-allowed-file-extensions="jpg" type="file" class="dropify" id="fotoSubir"
                               data-height="300"
                               name="foto"/>
                    </div>

                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input required id="first_name" type="text" class="validate" name="nombreProducto">
                        <label for="first_name">Nombre</label>
                    </div>

                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea  id="textarea2" class="materialize-textarea validate"
                                  data-length="255" name="descripcionProducto"></textarea>
                        <label for="textarea2">Descripción</label>
                    </div>

                </div>

                <div class="row">
                    <div class="input-field col s12 l6 xl6 m6">
                        <select required class="validate" name="tipoProducto">
                            <option value="" disabled selected>Elige una opción</option>
                            <?php foreach ($listaTipoProductos as $tipoProducto) { ?>
                                <option class="left"
                                        data-icon="https://cevicheriarichards.com/assets/images/carta/categorias/<?php echo $tipoProducto['imageUrl'] ?>"
                                        value="<?php echo $tipoProducto['idTipoProducto'] ?>"><?php echo $tipoProducto['nombre'] ?></option>
                            <?php } ?>
                        </select>
                        <label>Tipo Producto</label>
                    </div>

                    <div class="input-field col s12 l6 xl6 m6">
                        <input name="precioProducto" onkeypress="return solonumeros()" required id="precio" type="text"
                               class="validate">
                        <label for="precio">Precio</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col l6 xl6 m6 s12">
                        <a href="productos.php" style="margin: 8px"
                           class="btn btn-large red waves-effect waves-light"><i class="material-icons left">
                                arrow_back
                            </i>Volver</a>
                    </div>
                    <div class="col l6 xl6 m6 s12">
                        <button name="action" value="submit" type="submit" style="margin: 8px"
                                class="btn btn-large waves-effect waves-light"><i class="material-icons right">
                                add_circle_outline
                            </i>Insertar
                        </button>
                    </div>
                </div>


            </form>


        </div>
    </div>

</div>


<?php include 'layout/userFooter.php' ?>
<script src="library/js/dropify.min.js"></script>
<script>
    $(document).ready(function () {
        $('input#input_text, textarea#textarea2').characterCounter();
    });
    $('.dropify').dropify({
        messages: {
            'default': 'Click Aquí o arrastra un archivo',
            'replace': 'Click Aquí o arrastra un archivo para reemplazar',
            'remove': 'Eliminar',
            'error': 'Ooops, algo salió mal.'
        }
    });

    function solonumeros(e) {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
            return true;

        return /\d/.test(String.fromCharCode(keynum));
    };
</script>
</body>
</html>
