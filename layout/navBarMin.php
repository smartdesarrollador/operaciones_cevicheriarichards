<audio id="myAudio">
    <source src="sound/alarma-morning-mix.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<div class="navbar-fixed black">
    <nav class="animated ">
        <div class="nav-wrapper black">
            <div class="container">
                <a href="./" class="brand-logo deep-orange-text logoWSFPC center-align">
                    <img class="logoWSFPCImagen" src="img/logoMain.png" alt="">
                </a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger white-text text-darken-2"><i
                            class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">

                    <li><a class=" white-text capitalize" href="#!"
                        ><strong>Hola, <?= $_SESSION["current_fullName"] ?></strong></a></li>
                    <li><a title="Cerrar Sesión" onclick="return confirm('Estas Seguro?');"
                           class=" white-text capitalize" href="script/logOut.php"
                        ><strong><i class="material-icons">
                                    power_settings_new
                                </i></strong></a></li>

                </ul>
            </div>
        </div>

    </nav>
</div>

<ul class="sidenav " id="mobile-demo">
    <h2 class="deep-orange-text center-align"><img src="img/logoMain.png" width="40%" alt=""></h2>

    <li class="divider"></li>
    <li class="center-align"><p href="#" class="capitalize">Hola, <?= $_SESSION["current_fullName"] ?></p></li>


    <li class="divider"></li>


    <li class="center-align"><a href="script/logOut.php"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
    <li class="divider"></li>

</ul>
