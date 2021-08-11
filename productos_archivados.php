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
$listaProductos = $objProducto->getProductosArchivados();

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
<?php include 'layout/userNavBar.php' ?>
<div class="container">
    <div class="row">
        <div class="col l4 push-l4 pull-l4 s12 center-align z-depth-4 hoverable animated fadeIn"
             style="border-radius:5px;border: 2px solid black">
            <div class="row">
                <h5>Productos Archivados</h5>
                <p><em>Los productos archivados no se pueden ver en la carta.</em></p>
            </div>

        </div>
    </div>

</div>
<div class="container">

    <?php
    if (count($listaProductos) > 0) {
        foreach ($listaProductos as $producto) { ?>
            <div class="row z-depth-2 hoverable"
                 style="border: 2px solid rgb(197, 148, 62);border-radius: 8px;margin-bottom: 15px">
                <div class="col l4 m4 s12  xl4 l4">
                    <p>
                        <strong><u># <?php echo str_pad($producto['idProducto'], 5, "0", STR_PAD_LEFT); ?></u></strong>
                    </p>

                    <p>
                        <strong><?php echo $producto['nombreProducto'] ?></strong>
                    </p>
                    <p style="font-size: 14px">
                        <em><?php echo $producto['descripcionProducto'] ?></em>
                    </p>
                    <p>
                        <strong>S/ <?php echo $producto['precioProducto']; ?>.00</strong>
                    </p>
                </div>
                <div class="col l4 m4 s12  xl4 l4 ">
                    <img class="  center-block  z-depth-5 lazy"
                         style="width: 180px ;margin-top: 10px;margin-bottom: 10px"
                         data-src="https://cevicheriarichards.com/assets/images/carta/platos/<?php echo $producto['imagenProducto'] ?>"
                         alt="">
                </div>
                <div class="col l4 m4 s12  xl4 l4 center-align ">

                    <div style="margin-top: 50px;margin-bottom: 30px">

                        <a title="Restaurar Producto"
                           onclick="return confirm('Se va a restaurar el producto ¿Esta Seguro?');"
                           href="script/archivarAction.php?id=<?php echo $producto['idProducto'] ?>&status=0"
                           style="margin:15px"
                           class="btn-floating btn-large  waves-effect waves-light yellow darken-4"><i
                                    class="material-icons">restore</i></a>

                    </div>

                </div>
            </div>

        <?php }
    }else{
      ?>
        <div class="row z-depth-4 "
             style="border: 2px solid rgb(197, 148, 62);border-radius: 8px;margin-bottom: 15px">
                <div class="col l12 s12 m12 xl12 center-align">
                    <i class="material-icons" style="font-size: 100px;color: #ccc; padding-bottom: 10px;">
                        delete_outline
                    </i>
                    <h5>No hay productos archivados</h5>
                </div>
        </div>
        <?php
    } ?>


</div>

<?php include 'layout/userFooter.php' ?>
<script>
    var lazyLoadInstance = new LazyLoad({
        elements_selector: " .lazy "
        // ... más configuraciones personalizadas?
    });
</script>

<?php
if (isset($_GET['code'])) {
    if ($_GET['code'] == 'restored') { ?>
        <script>M.toast({html: 'Se ha restaurado el producto correctamente'})</script>
        <?php
    }
}
?>

</body>
</html>
