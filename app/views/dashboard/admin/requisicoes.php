<?php $this->layout('masterApp', ['title' => 'Requisições']);

use cefet\SyncLab\classes\Session;

/**
 * @var array $requisicoes Array associativo com as requisições
 */

function buildHeader()
{
    $type = Session::get('active');
    if ($type == "req-matricula") {
        echo '
            <tr class="table-row">
                <th class="table-head">Usuário</th>
                <th class="table-head">Número da Matrícula</th>
                <th class="table-head">Tipo da Matrícula</th>
                <th class="table-head">Status da Matrícula</th>
                <th class="table-head">Hora da Requisição</th>                
                <th class="table-head">Salvar</th>
            </tr>
        ';
    } else if ($type == "req-projeto") {
        echo '
            <tr class="table-row">
                <th class="table-head">Usuário</th>
                <th class="table-head">Nome do Projeto</th>
                <th class="table-head">Descrição do Projeto</th>
                <th class="table-head">Status do Projeto</th>
                <th class="table-head">Hora da Requisição</th>                
                <th class="table-head">Salvar</th>
            </tr>
        ';
    }
}

function buildBody(array $requisicoes)
{
    $type = Session::get('active');
    if ($type == "req-matricula") {
        foreach ($requisicoes as $requisicao) : ?>
            <tr class="table-row" data-id="<?= $requisicao['idMat'] ?>">
                <td class="table-data"><?= $requisicao['username'] ?></td>
                <td class="table-data"><?= $requisicao['matriculaMat'] ?></td>
                <td class="table-data"><?= $requisicao['tipoMat'] ?></td>
                <td class="table-data">
                    <select>
                        <option value="Em análise"><?= $requisicao['statusMat'] ?></option>
                        <option value="Ativo">Aceitar</option>
                        <option value="Rejeitado">Recusar</option>
                    </select>

                </td>
                <td class="table-data"><?= $requisicao['dataCriacaoMat'] ?></td>
                <td class="table-data"><button type="button" class="btn-success salvar-btn"><img class="table-svg-icon" src="/public/assets/images/paper-svgrepo-com.svg"></button></td>
            </tr>
        <?php endforeach;
    } else if ($type == "req-projeto") {
        foreach ($requisicoes as $requisicao) : ?>
            <tr class="table-row" data-id="<?= $requisicao['idProj'] ?>">
                <td class="table-data"><?= $requisicao['username'] ?></td>
                <td class="table-data"><?= $requisicao['nomeProj'] ?></td>
                <td class="table-data"><?= $requisicao['descricaoProj'] ?></td>
                <td class="table-data">
                    <select>
                        <option value="Em análise"><?= $requisicao['statusProj'] ?></option>
                        <option value="Ativo">Aceitar</option>
                        <option value="Rejeitado">Recusar</option>
                    </select>

                </td>
                <td class="table-data"><?= $requisicao['dataCriacaoProj'] ?></td>
                <td class="table-data"><button type="button" class="btn-success salvar-btn"><img class="table-svg-icon" src="/public/assets/images/paper-svgrepo-com.svg"></button></td>
            </tr>
        <?php endforeach;
    }
}

function buildTable(array $requisicoes)
{
    if (count($requisicoes) > 0) {
        ?>
        <table class="tablecontent" id="tipoReq" data-id="<?=Session::get('active')?>">
            <thead>
                <?= buildHeader() ?>
            </thead>
            <tbody>
                <?= buildBody($requisicoes) ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "<h2>Não há requisições a serem apresentadas</h2>";
    }
}

?>
<div id="main-content" class="main-content active">
    <?php echo \cefet\SyncLab\classes\Session::messageFlash() ?> 
    <?= buildTable($requisicoes) ?>
</div>

<script text="javascript" type="module" src="/public/assets/js/Controllers/Admin-Requisicoes.js"></script>