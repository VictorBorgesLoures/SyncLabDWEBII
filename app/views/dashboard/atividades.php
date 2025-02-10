<?php $this->layout("masterApp", ["title" => "Atividades"]);
\cefet\SyncLab\classes\Session::set('active', 'atividades');

/**
 * @var array $atividades acoes necessarias para os projetos
 */

?>
<div id="main-content" class="main-content active">
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">ID</th>
                <th class="table-head">Título</th>
                <th class="table-head">Status</th>
                <th class="table-head">Inicio</th>
                <th class="table-head">Entrega</th>
                <th class="table-head">Monitorar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($atividades as $atividade) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $atividade['idAtv'] ?></td>
                    <td class="table-data"><?= $atividade['tituloAtv'] ?></td>
                    <td class="table-data"><?= $atividade['statusAtv'] ?></td>
                    <td class="table-data"><?= $atividade['dataIniAtv'] ?></td>
                    <td class="table-data"><?= $atividade['dataFimAtv'] ?></td>
                    <td class="table-data"><a href=<?="/atividades/".$atividade['idAtv']?>><img class="table-svg-icon" src="/public/assets/images/paper-svgrepo-com.svg" ></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
