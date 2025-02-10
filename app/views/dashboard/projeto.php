<?php use cefet\SyncLab\classes\Session;

$this->layout('masterApp', ['title' => 'Projetos']);
Session::set('active', 'projetos');
/**
 * @var $projeto Projeto que o usuário está visualizando.
 * @var $reqParticipacao Requisições de participação no projeto.
 * @var $isTutor Se o usuário é tutor do projeto.
 * @var $possiveisTutores Possíveis tutores para o projeto.
*/
?>


<div id="main-content" class="main-content active">
    <div class="w-100">
        <?= $this->insert('includes/toasts') ?>
        <?= Session::messageFlash() ?>
    </div>
    <h2 class="fw-bold">Projeto: <?= $projeto['nomeProj']?> (#<?=$projeto['idProj']?>)</h2>
    <p><strong>Descrição:</strong> <?= $projeto['descricaoProj']?></p>
    <p><strong>Status:</strong> <?= $projeto['statusProj']?></p>
    <p><strong>Criado em:</strong> <?= $projeto['dataCriacaoProj']?></p>
    <p><strong>Tutor:</strong> <?= $projeto['tutor'] ?></p>
    <?php if (Session::get("type") == "docente"): ?>
        <form method="post" action="/projetos/alterar-tutor" class="row g-3 mb-4 align-items-center">
            <input type="hidden" name="idProj" value="<?= $projeto['idProj'] ?>">

            <div class="col-auto">
                <label for="tutor" class="form-label">Alterar Tutor</label>
            </div>
            <div class="col-auto">
                <select name="tutor" id="tutor" class="form-select">
                    <?php foreach ($possiveisTutores as $tutor): ?>
                        <option value="<?= $tutor['idMat'] ?>"><?= $tutor['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <img class="table-svg-icon" src="/public/assets/images/pencil-file-svgrepo-com.svg" alt="edit">
                    Alterar
                </button>
            </div>
        </form>
    <?php endif; ?>
    <p><strong>Atualizado em:</strong> <?= $projeto['dataAtualizacao']?></p>

    <a class="btn btn-primary login-btn mb-2" href=<?=$projeto['idProj']."/atividades"?> >Atividades</a>

    <h4 class="fw-bold">Participantes</h4>
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome</th>
                <th class="table-head">Matrícula</th>
                <th class="table-head">Tipo</th>
                <th class="table-head">Início</th>
                <th class="table-head">Fim</th>
                <?php if(Session::get("type") == "docente" ):?>
                    <th class="table-head">Finalizar</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projeto['participantes'] as $participante) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $participante['discente_nome'] ?></td>
                    <td class="table-data"><?= $participante['discente_matricula'] ?></td>
                    <td class="table-data"><?= \cefet\SyncLab\Helper\Helpers::matriculaType($participante['tipoMat']) ?></td>
                    <td class="table-data"><?= $participante['dataInicio'] ?></td>
                    <td class="table-data"><?= $participante['dataFim'] ?? '-' ?></td>

                    <?php if (Session::get("type") == "docente" && !isset($participante['dataFim'])): ?>
                    <td class="table-data">
                        <button type="button" class="btn-success" onclick="abrirModalConfirmacao(<?= $participante['matricula_id'] ?>)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php if(Session::get("type") == "docente" ):?>
    <div class="text-end mt-4">
        <button type="button" class="login-btn mb-5" data-bs-toggle="modal" data-bs-target="#adicionarDiscente">
            Adicionar Discente
        </button>
    </div>
    
    <h6 class="fw-bold">Requisições Pendentes:</h6>
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome</th>
                <th class="table-head">Matrícula</th>
                <th class="table-head">Status</th>
                <th class="table-head">Enviar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reqParticipacao as $requisicao) : ?>
            <tr class="table-row" data-req="<?= $requisicao['fk_Matricula_idMat'] ?>/<?= $requisicao['fk_Projeto_idProj'] ?>">
                <td class="table-data"><?= $requisicao['discente_nome'] ?></td>
                <td class="table-data"><?= $requisicao['discente_matricula'] ?></td>
                <td class="table-data">
                    <select>
                        <option value="Ativo">Aceitar</option>
                        <option value="Recusado">Recusar</option>
                    </select>
                </td>
                <td class="table-data">
                    <button type="button" class="req-btn">
                        <img class="table-svg-icon" src="/public/assets/images/pencil-file-svgrepo-com.svg" alt="edit">
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?= $this->insert('includes/modalAdicionarDiscente') ?>
<?= $this->insert('includes/modalFimParticipacao') ?>
<?php endif ?>
<script type="module" src="/public/assets/js/Controllers/gerenciarProjetos.js"></script>
<script src="/public/assets/js/Controllers/modalConfirmacao.js"></script>