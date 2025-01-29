<?php
use cefet\SyncLab\classes\Session;
?>
<header>
    <nav class="navbar">
        <div id="sidebar-btn" class="logo-container">
            <img alt="SyncLab" src="/public/assets/images/logo-nome.png" class="navlogo logo-name" />
            <img alt="logo do SyncLab" src="/public/assets/images/logo-ampulheta.png" class="navlogo ampulheta" />
        </div>
        <div class="navbuttons dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= Session::get('user_name') !== null ? Session::get('user_name') : 'UNDEFINED'?> 
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/matricula">Matriculas</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>