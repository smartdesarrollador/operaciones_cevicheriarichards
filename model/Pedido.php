<?php
/**
 * Created by PhpStorm.
 * Developer: Johen Guevara Santos.
 * Email: mguevara@enfocussoluciones.com
 * Date: 25/09/2019
 * Time: 12:17
 */
require_once "ConexionBD.class.php";
require_once("AccesoBD.class.php");

class Pedido
{
    private $cn;

    //EL CONSTRUCTOR CONSTRUYE LA VARIABLE $cn
    function __construct()
    {
        try {
            $con = ConexionBD::CadenaCN();
            $this->cn = AccesoBD::ConexionBD($con);
            $this->cn->query("SET NAMES 'utf8'");   //ACENTOS UTF8
            $this->cn->set_charset('utf8mb4');   //ACENTOS UTF8
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getPedidosByDate($fechaPedido)
    {
        try {
            $sql = "SELECT * FROM clientes INNER JOIN pedidos ON clientes.idCliente = pedidos.idCliente
                    where fechaPedido = '$fechaPedido' ORDER BY horaPedido DESC ";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function getPedidosItemsByidPedido($idPedido)
    {
        try {
            $sql = "select productos.idProducto as codigoProducto,nombreProducto,cantidad,item_descripcion,precioProducto from pedidos INNER JOIN pedido_items ON pedidos.idPedido = pedido_items.idPedido 
                    INNER JOIN productos ON pedido_items.idProducto = productos.idProducto WHERE pedidos.idPedido = '$idPedido'";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function getPedidosLimit50()
    {
        try {
            $sql = "SELECT * FROM clientes INNER JOIN pedidos ON clientes.idCliente = pedidos.idCliente
                     ORDER BY idPedido DESC LIMIT 50 ";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function getAllPedidos()
    {
        try {
            $sql = "SELECT * FROM clientes INNER JOIN pedidos ON clientes.idCliente = pedidos.idCliente ";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function changeFeedBackStatus($idPedido, $status, $token)
    {
        $sql = "UPDATE pedidos set
                feedBackEnviado= '$status',feedBackToken='$token' where idPedido = '$idPedido'";
        $id = AccesoBD::Insertar($this->cn, $sql);
        return $id;
    }

    public function getCountOfPEdidos()
    {
        try {
            $sql = "SELECT count(idPedido) as total FROM pedidos ";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function updateOrderStatus($idEstado, $idPedido)
    {
        $sql = "UPDATE pedidos set
                idEstado= '$idEstado' where idPedido = '$idPedido'";
        $id = AccesoBD::Insertar($this->cn, $sql);
        return $id;
    }

    public function getPedidoByID($idPedido)
    {
        try {
            $sql = "SELECT * FROM clientes INNER JOIN pedidos ON clientes.idCliente = pedidos.idCliente 
 WHERE idPedido = '$idPedido' ORDER BY horaPedido DESC ";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }
    public function reporteVentasUltimos6Meses()
    {
        try {
            $cast = "SET lc_time_names = 'es_ES';";
            $sql = "SELECT SUM(precioTotal) as montoVentas,MONTHNAME(fechaPedido) as mes FROM pedidos WHERE CHAR_LENGTH(idCliente)>0 GROUP BY MONTHNAME(fechaPedido) ORDER BY fechaPedido ASC";
            AccesoBD::OtroSQL($this->cn, $cast);
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }
    public function generarExcelPrimerReporte($monthAndYear)
    {
        try {
            $arrDate = explode('-', $monthAndYear);

            $year = $arrDate[0];
            $month = $arrDate[1];


            $sql = "SELECT * FROM pedidos WHERE MONTH(fechaPedido) = '$month' AND YEAR(fechaPedido) = '$year' AND CHAR_LENGTH(idCliente)>0";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

}
