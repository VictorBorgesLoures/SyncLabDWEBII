<?php $this->layout('masterApp', ['title' => 'Laboratórios']);
\cefet\SyncLab\classes\Session::set('active', 'laboratorios');

/**
 * @var array $laboratorios Laboratórios a serem exibidos
 */

?>

<div id="main-content" class="main-content active">
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome do Laboratório</th>
                <th class="table-head">Nº Pessoas</th>
                <th class="table-head">Status</th>
                <th class="table-head">Monitorar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laboratorios as $laboratorio) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $laboratorio['nomeLab'] ?></td>
                    <td class="table-data"><?= $laboratorio['numPessoas'] ?></td>
                    <td class="table-data"><?= $laboratorio['status'] ?></td>
                    <td class="table-data"><a href="/laboratorio/<?= $laboratorio['id'] ?>"><img class="table-svg-icon" src="/public/assets/images/paper-svgrepo-com.svg" ></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

