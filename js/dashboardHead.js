function changeStatus(idEstado, idPedido) {
    var idEstado = idEstado
    var idPedido = idPedido;


    var url = "ajax/changeOrderStatus.php";

    var datos = {idEstado: idEstado, idPedido: idPedido};
    $.post(url, datos, function (data) {
        if (data < 1) {

        }
    }).done(function() {
        location.reload();
    }).fail(function () {
        alert("Se produjo un error, Verifica tu conexion a internet");
    })

}

function dia_semana(d1, d2, d3, d4, d5, d6, d7) {
    this[0] = d1;
    this[1] = d2;
    this[2] = d3;
    this[3] = d4;
    this[4] = d5;
    this[5] = d6;
    this[6] = d7;
}

function mes_ano(d1, d2, d3, d4, d5, d6, d7, d8, d9, d10, d11, d12) {
    this[0] = d1;
    this[1] = d2;
    this[2] = d3;
    this[3] = d4;
    this[4] = d5;
    this[5] = d6;
    this[6] = d7;
    this[7] = d8;
    this[8] = d9;
    this[9] = d10;
    this[10] = d11;
    this[11] = d12;
}

semana = new dia_semana("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

mes = new mes_ano("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

var today = new Date;
diahoy = today.getDay();
fechahoy = today.getDate();
meshoy = today.getMonth();
horahoy = today.getHours();
minutohoy = today.getMinutes();
ano = today.getFullYear();

function dia() {


    document.getElementById("fechaActual").innerHTML = semana[diahoy] + ' ' + fechahoy + ' de ' + mes[meshoy] + ' del ' + ano;
}
