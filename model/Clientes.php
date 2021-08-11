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

class Clientes
{
    private $cn;

    //EL CONSTRUCTOR CONSTRUYE LA VARIABLE $cn
    function __construct()
    {
        try {
            $con = ConexionBD::CadenaCN();
            $this->cn = AccesoBD::ConexionBD($con);
            $this->cn->query("SET NAMES 'utf8'");   //ACENTOS UTF8
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getPuntosClientes()
    {
        try {
            $sql = "select nombre,apellido, email,puntos from clientes";
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
    public function getClienteById($idCliente)
    {
        try {
            $sql = "select * from clientes where idCliente='$idCliente'";
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
    public function getComprasxCliente()
    {
        try {
            $sql = "select nombre, apellido,email, SUM(precioTotal) as total from clientes INNER JOIN pedidos 
                    on clientes.idCliente = pedidos.idCliente group by pedidos.idCliente";
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
    public function aumentarPuntosCliente($idCliente, $puntos)
    {

        $sql = "UPDATE clientes SET puntos = puntos+'$puntos' WHERE idCliente =  '$idCliente'";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function reducirSaldoCliente($idCliente, $saldo)
    {

        $sql = "UPDATE clientes SET saldoBilletera = saldoBilletera-'$saldo' WHERE idCliente =  '$idCliente'";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

}
