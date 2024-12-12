<?php
use cefet\SyncLab\classes\Session;
?>
<aside id="side-navbar" class="side-bar active">
    <ul class="side-navbar">
        <li class="side-navbar-li <?= Session::get('active') == 'dashboard' ? 'active' : ''?>"><a href="/dashboard" class="side-navbar-link">Dashboard</a>
        </li>
        <li class="side-navbar-li <?= Session::get('active') == 'projetos' ? 'active' : ''?>"><a href="/projetos" class="side-navbar-link">Projetos</a></li>
        <li class="side-navbar-li <?= Session::get('active') == 'requisicoes' ? 'active' : ''?>"><a href="/requisicoes" class="side-navbar-link">Requisições</a>
        </li>
        <li class="side-navbar-li  <?= Session::get('active') == 'acoes' ? 'active' : ''?>"><a href="/acoes" class="side-navbar-link">Ações</a></li>
        <li class="side-navbar-li  <?= Session::get('active') == 'laboratorios' ? 'active' : ''?>"><a href="/laboratorios" class="side-navbar-link">Laboratórios</a>
        </li>
    </ul>
</aside>

<?= Session::remove('active')?>