<?php
include '../model/Producto.php';
$objProducto = new Producto();


$listaProductos = "";
if (isset($_POST['consulta'])) {
    $q = $_POST['consulta'];
    $listaProductos = $objProducto->getProductosBySearch($q);

} else {
    $listaProductos = $objProducto->getProductos();
}

?>
<script>

</script>
<?php foreach ($listaProductos as $producto) { ?>
    <div class="row z-depth-2 "
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
            <img class="  center-block lazy"
                 style="width: 180px ;margin-top: 10px;margin-bottom: 10px"
                 data-src="https://cevicheriarichards.com/assets/images/carta/platos/<?php echo $producto['imagenProducto'] ?>"
                 alt="">
        </div>
        <div class="col l4 m4 s12  xl4 l4 center-align ">

            <div style="margin-top: 50px;margin-bottom: 30px">

                <strong><u>¿Stock?</u></strong>
                <div class="switch">
                    <label>
                        NO
                        <?php if ($producto['stock'] == 'YES') { ?>
                            <input  data-idProducto="<?php echo $producto['idProducto']; ?>" class="chkStock" checked
                                   type="checkbox">
                        <?php } else { ?>
                            <input  data-idProducto="<?php echo $producto['idProducto']; ?>" class="chkStock"
                                   type="checkbox">
                        <?php } ?>

                        <span class="lever"></span>
                        SI
                    </label>
                </div>
                <a title="Editar Producto" href="updateProduct?id=<?php echo $producto['idProducto']?>" style="margin:15px"
                   class="btn-floating  waves-effect waves-light yellow darken-4"><i class="material-icons">edit</i></a>

            </div>

        </div>
    </div>

<?php } ?>

<script>


    lazyLoadInstance.update();


    $(".chkStock").on("click", function (e) {
        var checkbox = $(this);
        var url = "ajax/changeStockStatus.php";
        var id = $(this).attr("data-idProducto");


        if (checkbox.is(":checked")) {

            var stock = "YES";
            var datos = {id: id, stock: stock};
            $.post(url, datos, function (data) {
                console.log(data);
            }).fail(function () {
                alert("Se produjo un error, Verifica tu conexión a internet");
                location.reload();
            });
        } else {
            var stock = "NOT";
            var datos = {id: id, stock: stock};
            $.post(url, datos, function (data) {
                console.log(data);
            }).fail(function () {
                alert("Se produjo un error, Verifica tu conexión a internet");
                location.reload();
            });
        }
    });

    /*$('.chkStock').change(function() {
        console.log("cambio");
      let valor = $(this).attr("data-idProducto");


      alert(valor);

    });*/

</script>


