<?php

use cefet\SyncLab\classes\Session;

$tipo_Usuario = Session::get('type');

function loadSideBar(string $type)
{
    if ($type == NULL) {
        echo "<script type='text/javascript'> window.location.replace('/login') </script>";
    } else if ($type == "admin") {
?>
        <li class="side-navbar-li <?= Session::get('active') == 'dashboard' ? 'active' : '' ?>"><a href="/dashboard" class="side-navbar-link">Dashboard</a>
        </li>
        <li class="side-navbar-li">
            <p data-bs-toggle="collapse" href="#collapseSubMenuRequisicoes" role="button" aria-expanded="false" aria-controls="collapseSubMenuRequisicoes">Requisições</p>
            <ul class="side-navbar <?= (Session::get('active') == 'req-matricula' || Session::get('active') == 'req-projeto') ? 'show' : 'collapsed collapse' ?>" type="button" id="collapseSubMenuRequisicoes" data-bs-target="#collapseSubMenuRequisicoes" aria-expanded="false" aria-controls="collapseSubMenuRequisicoes">
                <li class="side-navbar-li sub-side-li <?= Session::get('active') == 'req-matricula' ? 'active' : '' ?>"><a href="/requisicoes/matricula" class="side-navbar-link">Matrículas</a></li>
                <li class="side-navbar-li sub-side-li <?= Session::get('active') == 'req-projeto' ? 'active' : '' ?>"><a href="/requisicoes/projeto" class="side-navbar-link">Projetos</a></li>
            </ul>

        </li>
    <?php
    } else if ($type == "discente") {
    ?>
        <li class="side-navbar-li <?= Session::get('active') == 'dashboard' ? 'active' : '' ?>"><a href="/dashboard" class="side-navbar-link">Dashboard</a>
        </li>
        <li class="side-navbar-li <?= Session::get('active') == 'projetos' ? 'active' : '' ?>"><a href="/projetos" class="side-navbar-link">Projetos</a></li>
        <li class="side-navbar-li  <?= Session::get('active') == 'atividades' ? 'active' : '' ?>"><a href="/atividades" class="side-navbar-link">Atividades</a></li>
    <?php
    } else if ($type == "docente") {
    ?>
        <li class="side-navbar-li <?= Session::get('active') == 'dashboard' ? 'active' : '' ?>"><a href="/dashboard" class="side-navbar-link">Dashboard</a>
        </li>
        <li class="side-navbar-li <?= Session::get('active') == 'projetos' ? 'active' : '' ?>"><a href="/projetos" class="side-navbar-link">Projetos</a></li>
        <li class="side-navbar-li  <?= Session::get('active') == 'atividades' ? 'active' : '' ?>"><a href="/atividades" class="side-navbar-link">Atividades</a></li>
<?php
    } else {
        echo "<script type='text/javascript'> window.location.replace('/login') </script>";
    }
    return;
}
?>
<aside id="side-navbar" class="side-bar active">
    <ul class="side-navbar">
        <?php
        loadSideBar($tipo_Usuario);
        ?>
    </ul>
</aside>

<?= Session::remove('active') ?>