<?php $this->layout('masterApp', ['title' => 'Projetos']);
\cefet\SyncLab\classes\Session::set('active', 'projetos');

/**
 * @var array $projetos Projetos que o usuário está vinculado.
 */
?>

<div id="main-content" class="main-content active">
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome do Projeto</th>
                <th class="table-head">Tutor</th>
                <th class="table-head">Co-Tutores</th>
                <th class="table-head">Gerenciar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projetos as $projeto) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $projeto['nome'] ?></td>
                    <td class="table-data"><?= $projeto['tutor'] ?></td>
                    <td class="table-data"><?= implode(", ", $projeto['coTutores']) ?></td>
                    <td class="table-data"><img class="table-svg-icon" src="/public/assets/images/pencil-file-svgrepo-com.svg"  alt="edit"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


