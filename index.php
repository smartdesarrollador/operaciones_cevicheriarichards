<?php
session_start();
error_reporting(0);

if (isset($_SESSION["current_email"]) || $_SESSION["current_email"] != '') {

header('location: dashboard');
exit();
}
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>.::Login::.</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-page">
    <div class="form" >
        <h5> <img width="70%" src="img/logoMain.png"> </h5>
        <form class="login-form" method="post" action="script/validarSesion.php">
            <input style="text-transform: lowercase" required type="text" name="email" placeholder="email" autocomplete="on" />
            <input required type="password" name="password" placeholder="password" autocomplete="on"/>
            <input type="hidden" name="code" value="<?php echo session_id()?>"/>
            <button name="submit" type="submit">login</button>

        </form>
    </div>
</div>


</body>
</html>
