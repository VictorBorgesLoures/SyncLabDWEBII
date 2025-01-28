<?php $this->layout('masterApp', ['title' => 'Projetos']);
\cefet\SyncLab\classes\Session::set('active', 'projetos');
/**
 * @var $projeto Projeto que o usuário está visualizando.
 * @var $reqParticipacao Requisições de participação no projeto.
 */
?>


<div id="main-content" class="main-content active">
    <h2 class="fw-bold">Projeto: <?= $projeto['nomeProj']?> (#<?=$projeto['idProj']?>)</h2>
    <p><strong>Descrição:</strong> <?= $projeto['descricaoProj']?></p>
    <p><strong>Status:</strong> <?= $projeto['statusProj']?></p>
    <p><strong>Criado em:</strong> <?= $projeto['dataCriacaoProj']?></p>
    <p><strong>Tutor:</strong> <?= $projeto['tutor'] ?></p>
    <p><strong>Atualizado em:</strong> <?= $projeto['dataAtualizacao']?></p>

    <h4 class="fw-bold">Participantes</h4>
    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome</th>
                <th class="table-head">Matrícula</th>
                <th class="table-head">Tipo</th>
                <th class="table-head">Início</th>
                <th class="table-head">Fim</th>
                <th class="table-head">Atividade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projeto['discentes'] as $discente) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $discente['discente_nome'] ?></td>
                    <td class="table-data"><?= $discente['discente_matricula'] ?></td>
                    <td class="table-data"><?= \cefet\SyncLab\Helper\Helpers::matriculaType($discente['tipoMat']) ?></td>
                    <td class="table-data"><?= $discente['dataInicio'] ?></td>
                    <td class="table-data"><?= $discente['dataFim'] ?? '-' ?></td>
                    <td class="table-data">
                        <a href="">
                            <button type="button" class="btn-success">
                                <img class="table-svg-icon" src="/public/assets/images/pencil-file-svgrepo-com.svg" alt="edit">
                            </button>
                        </a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h6 class="fw-bold">Requisições Pendentes:</h6>
    <div class="text-end">
        <button type="button" class="login-btn mb-5" data-bs-toggle="modal" data-bs-target="#adicionarDiscente">
          Adicionar Discente
        </button>
    </div>

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

<div class="modal fade" id="adicionarDiscente" tabindex="-1" aria-labelledby="adicionarDiscente" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pesquisaUsuarioModalLabel">Inserir  Discente ao Projeto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPesquisaUsuario" class="mb-5">
                    <div class="mb-3">
                        <label for="nomeUsuario" class="form-label">Nome do Usuário ou Matrícula</label>
                        <input type="text" class="form-control" id="nomeUsuario" placeholder="Digite o nome do usuário ou matrícula">
                    </div>
                </form>
                <table class="tablecontent">
                  <thead>
                    <tr class="table-row">
                      <th class="table-head">Nome</th>
                      <th class="table-head">Matrícula</th>
                      <th class="table-head">Adicionar</th>
                    </tr>
                  </thead>
                  <tbody id="resultados"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script text="javascript" type="module" src="/public/assets/js/Controllers/gerenciarProjetos.js"></script>
