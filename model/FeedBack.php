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

class FeedBack
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


    public function getFeedBacksByDate($fechaPedido)
    {
        try {
            $sql = "SELECT
	* 
FROM
	clientes
	INNER JOIN pedidos ON clientes.idCliente = pedidos.idCliente
	INNER JOIN feedback ON pedidos.idPedido = feedback.idPedido
	WHERE pedidos.fechaPedido = '$fechaPedido'
ORDER BY
	pedidos.idPedido DESC 
	LIMIT 50 ";
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


    public function getFeedBackLimit50()
    {
        try {
            $sql = "SELECT
	* 
FROM
	clientes
	INNER JOIN pedidos ON clientes.idCliente = pedidos.idCliente
	INNER JOIN feedback ON pedidos.idPedido = feedback.idPedido
ORDER BY
	pedidos.idPedido DESC 
	LIMIT 50";
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
