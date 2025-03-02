<?php
use cefet\SyncLab\classes\Session;
?>
<header>
    <nav class="navbar container">
        <img alt="logo do SyncLab" src="/public/assets/images/synclab img.webp" class="navlogo"/>
        <ul class="navbuttons">
            <li class="navlink <?= Session::get('active') == 'home' ? 'ativo' : ''?>"><a href="/">home</a></li>
            <li class="navlink <?= Session::get('active') == 'contato' ? 'ativo' : ''?>"><a href="/contato">contato</a></li>
            <li class="navlink <?= Session::get('active') == 'sobre' ? 'ativo' : ''?>"><a href="/sobre">sobre</a></li>
            <?php if(Session::get('loggedin')): ?>
                <li class="user-menu">
                    <a href="/matricula"><button class="navlink botao">Matrícula</button></a>
                    <ul class="submenu">
                        <li><a href="/logout">Sair</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="/login"><button class="navlink botao <?= Session::get('active') == 'login' ? 'ativo' : ''?>">conectar-se</button></a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<?= Session::remove('active')?>
