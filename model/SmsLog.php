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

class SmsLog
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
    public function addNewSmsLog($destino,$url)
    {
        $actualDateTime = time();
        date_default_timezone_set('America/Lima');
        $sql = "INSERT INTO sms_log(dateTime,destino,url)
					VALUES('$actualDateTime','$destino','$url')";
        $id = AccesoBD::InsertAndGetLastId($this->cn, $sql);
        return $id;
    }

}
