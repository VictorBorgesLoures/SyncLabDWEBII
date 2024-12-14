<?php
use cefet\SyncLab\classes\Session;
?>
<header>
    <nav class="navbar">
        <div id="sidebar-btn" class="logo-container">
            <img alt="SyncLab" src="/public/assets/images/logo-nome.png" class="navlogo logo-name" />
            <img alt="logo do SyncLab" src="/public/assets/images/logo-ampulheta.png" class="navlogo ampulheta" />
        </div>
        <ul class="navbuttons">
            <li class="dash-nav-option"><?= Session::get('user') !== null ? Session::get('user') : 'UNDEFINED'?> </li>
            <li><a href="/login"><button class="navlink dash-nav-option botao">Sair</button></a></li>
        </ul>
    </nav>
</header>