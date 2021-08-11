<?php
session_start();
error_reporting(0);
$page = 'products';
if (isset($_SESSION["current_email"]) && $_SESSION["current_email"] != '') {

} else {
    echo "Usuario no Autorizado";
    exit();
}

if ($_SESSION['current_rol'] == 'admin') {

} else {
    echo "No tienes Permisos para acceder a este lugar";
    exit();
}


include 'model/Producto.php';
$objProducto = new Producto();
$listaProductos = $objProducto->getProductos();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.::Dashboard::.</title>
    <?php include 'layout/library.php' ?>
    <script src="library/js/intersection-observer.js"></script>
    <script src="library/js/lazyload.min.js"></script>

    <style>
        p {
            margin: 4px;
        }

        .row {
            padding: 20px;
        }
    </style>

</head>
<body>


<div class="fixed-action-btn">
    <button class="btn-floating btn-large red waves-effect waves-light">
        <i class="large material-icons">mode_edit</i>
    </button>
    <ul>
        <li><a class="btn-floating red waves-effect waves-light" href="addProduct" title="Añadir Productos"><i
                        class="material-icons">add</i></a></li>
        <li><a class="btn-floating blue waves-effect waves-light" href="productos_archivados"
               title="Ver Productos Archivados"><i class="material-icons">delete</i></a></li>

    </ul>
</div>
<?php include 'layout/userNavBar.php' ?>
<div class="container">
    <div class="row">
        <div class="col l4 push-l4 pull-l4 s12 center-align animated fadeIn"
             style="border-radius:5px;border: 2px solid black">
            <div class="row">
                <h6>Buscar por Nombre</h6>
                <div class="input-field col s12">
                    <input id="caja_busqueda" type="text" class="validate">
                    <label for="caja_busqueda"><i class="material-icons">search</i></label>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="container">
    <div id="datos"></div>

</div>

<?php include 'layout/userFooter.php' ?>
<script>
    var lazyLoadInstance = new LazyLoad({
        elements_selector: " .lazy "
        // ... más configuraciones personalizadas?
    });

    //BUSQUEDA
    $(buscar_datos());

    function buscar_datos(consulta) {


        $.ajax({
            url: 'ajax/buscarProductos.php',
            type: 'POST',
            dataType: 'html',
            data: {consulta: consulta},
            beforeSend: function () {
                $("#datos").html(
                    "\n" +
                    " <div class='row center-align' style='margin-top: 22%'>" +
                    "  <div class=\"preloader-wrapper center-align big active\">\n" +
                    "    <div class=\"spinner-layer spinner-blue-only\">\n" +
                    "      <div class=\"circle-clipper left\">\n" +
                    "        <div class=\"circle\"></div>\n" +
                    "      </div><div class=\"gap-patch\">\n" +
                    "        <div class=\"circle\"></div>\n" +
                    "      </div><div class=\"circle-clipper right\">\n" +
                    "        <div class=\"circle\"></div>\n" +
                    "      </div>\n" +
                    "    </div>\n" +
                    "  </div></div>");
            },
        })
            .done(function (respuesta) {
                $("#datos").html(respuesta);
            })
            .fail(function () {
                console.log("error");
            });


    }

    $(document).on('keyup', '#caja_busqueda', function () {

        var valor = $(this).val();
        if (valor != "") {
            buscar_datos(valor);
        } else {
            buscar_datos();
        }

    });

    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton();
    });


</script>
<?php
if (isset($_GET['code'])) {
if ($_GET['code'] == 'success') { ?>
    <script>M.toast({html: 'Exito! Se ha Insertado el Nuevo Producto!'})</script>
<?php
}
if ($_GET['code'] == 'updateSuccess') { ?>
    <script>M.toast({html: 'Producto actualizado correctamente!'})</script>
    <?php
}
    if ($_GET['code'] == 'archived') { ?>
    <script>M.toast({html: 'Se ha archivado el producto con éxito'})</script>
    <?php
}
}
?>

</body>
</html>
