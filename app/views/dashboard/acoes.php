<?php $this->layout("masterApp", ["title" => "Ações"]);
\cefet\SyncLab\classes\Session::set('active', 'acoes');

/**
 * @var array $acoes acoes necessarias para os projetos
 */

?>
<div id="main-content" class="main-content active">
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome do Projeto</th>
                <th class="table-head">Atividade</th>
                <th class="table-head">Atuantes</th>
                <th class="table-head">Inicio</th>
                <th class="table-head">Entrega</th>
                <th class="table-head">Monitorar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($acoes as $acao) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $acao['projeto'] ?></td>
                    <td class="table-data"><?= $acao['atividade'] ?></td>
                    <td class="table-data"><?= $acao['atuantes'] ?></td>
                    <td class="table-data"><?= $acao['inicio'] ?></td>
                    <td class="table-data"><?= $acao['entrega'] ?></td>
                    <td class="table-data"><img class="table-svg-icon" src="/public/assets/images/paper-svgrepo-com.svg" ></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
