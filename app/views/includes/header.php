<header>
    <nav class="navbar container">
        <img alt="logo do SyncLab" src="/public/assets/images/synclab img.webp" class="navlogo"/>
        <ul class="navbuttons">
            <li class="navlink <?= \cefet\Adequa\classes\Session::get('active') == 'home' ? 'ativo' : ''?>"><a href="/">home</a></li>
            <li class="navlink <?= \cefet\Adequa\classes\Session::get('active') == 'contato' ? 'ativo' : ''?>"><a href="/contato">contato</a></li>
            <li class="navlink <?= \cefet\Adequa\classes\Session::get('active') == 'sobre' ? 'ativo' : ''?>"><a href="/sobre">sobre</a></li>
            <li><a href="/login.html"><button class="navlink botao">conectar-se</button></a></li>
        </ul>
    </nav>
</header>

<?= \cefet\Adequa\classes\Session::remove('active')?>
