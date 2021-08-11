<?php
session_start();
function filtrado($datos){
    $datos = trim($datos); // Elimina espacios antes y después de los datos
    $datos = stripslashes($datos); // Elimina backslashes \
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    return $datos;
}
require_once '../model/Administrator.php';

if(isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST" && session_id() == $_POST["code"]){

$objAdministrator = new administrator();
   $email = filtrado($_POST['email']);
   $password = filtrado($_POST['password']);

$lista = $objAdministrator->getAdministratorByEmail($email);

    if (password_verify($password, $lista['password'])) {

        if (trim($lista['rol'])=='ADMIN'){
             $_SESSION['current_email'] = $lista['correo'];
            $_SESSION['current_fullName'] = $lista['nombre'];
            $_SESSION['current_rol'] = 'admin';



            header("location: ../dashboard");

        }else{
            $_SESSION['current_email'] = $lista['correo'];
            $_SESSION['current_fullName'] = $lista['nombre'];
            $_SESSION['current_rol'] = 'motorizado';


            header("location: ../dashboardMin");
        }



    }else{
    header("location: ../error");
    }

}else{
    echo "Usuario no autorizado";
}
