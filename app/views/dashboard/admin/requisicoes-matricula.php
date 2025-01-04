<?php $this->layout('masterApp', ['title' => 'Requisições - Matrícula']);
\cefet\SyncLab\classes\Session::set('active', 'req-matricula');

/**
 * @var array $requisicoes Array associativo com as requisições
 */

?>
<div id="main-content" class="main-content active">
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome do Projeto</th>
                <th class="table-head">Laboratório</th>
                <th class="table-head">Assunto</th>
                <th class="table-head">Status</th>
                <th class="table-head">Monitorar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requisicoes as $requisicao) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $requisicao['nomeProjeto'] ?></td>
                    <td class="table-data"><?= $requisicao['laboratorio'] ?></td>
                    <td class="table-data"><?= $requisicao['assunto'] ?></td>
                    <td class="table-data"><?= $requisicao['status'] ?></td>
                    <td class="table-data"><img class="table-svg-icon" src="/public/assets/images/paper-svgrepo-com.svg" ></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
