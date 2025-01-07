<?php $this->layout('masterApp', ['title' => 'Projetos']);
\cefet\SyncLab\classes\Session::set('active', 'projetos');
/**
 * @var $projeto Projeto que o usuário está visualizando.
 */
?>

<h2>Projeto</h2>
<?=var_dump($projeto)?>