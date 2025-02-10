<?php use cefet\SyncLab\classes\Session;

$this->layout("masterApp", ["title" => "Atividades"]);
\cefet\SyncLab\classes\Session::set('active', 'atividades');

/**
 * @var array $atividade acoes necessarias para os projetos
 * @var $docente se o usuario é docente
 */
?>
<div id="main-content" class="main-content active">
    <?= $this->insert('includes/toasts') ?>
    <div class="card w-90">
        <?php if ($docente) : ?>
            <div class="card-header">
                <h2 class="card-title"><?= htmlspecialchars($atividade['tituloAtv']) ?> (#<?= $atividade['idAtv'] ?>)</h2>
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <span class="badge bg-warning text-dark"><?= htmlspecialchars($atividade['statusAtv']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Projeto ID:</strong>
                        <span><?= $atividade['fk_Projeto_idProj'] ?></span>
                    </div>
                </div>
                <form id="atividade-form">
                    <input type="hidden" name="idAtv" value="<?= $atividade['idAtv'] ?>">
                    <input type="hidden" name="fk_Projeto_idProj" value="<?= $atividade['fk_Projeto_idProj'] ?>">

                    <div class="mb-3">
                        <label for="tituloAtv" class="form-label"><strong>Alterar Título:</strong></label>
                        <input type="text" class="form-control" id="tituloAtv" name="tituloAtv" value="<?= htmlspecialchars($atividade['tituloAtv']) ?>">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dataIniAtv" class="form-label"><strong>Data de Início:</strong></label>
                            <input type="datetime-local" class="form-control" id="dataIniAtv" name="dataIniAtv" value="<?= date('Y-m-d\TH:i', strtotime($atividade['dataIniAtv'])) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="dataFimAtv" class="form-label"><strong>Data de Término:</strong></label>
                            <input type="datetime-local" class="form-control" id="dataFimAtv" name="dataFimAtv" value="<?= date('Y-m-d\TH:i', strtotime($atividade['dataFimAtv'])) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="statusAtv" class="form-label"><strong>Status:</strong></label>
                        <select class="form-select" id="statusAtv" name="statusAtv">
                            <option value="Finalizada" <?= $atividade['statusAtv'] === 'Finalizada' ? 'selected' : '' ?>>Finalizada</option>
                            <option value="Em análise" <?= $atividade['statusAtv'] === 'Em análise' ? 'selected' : '' ?>>Em análise</option>
                            <option value="Em andamento" <?= $atividade['statusAtv'] === 'Em andamento' ? 'selected' : '' ?>>Em andamento</option>
                            <option value="Em andamento" <?= $atividade['statusAtv'] === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descricaoAtv" class="form-label"><strong>Descrição:</strong></label>
                        <textarea class="form-control" id="descricaoAtv" name="descricaoAtv" rows="3"><?= htmlspecialchars($atividade['descricaoAtv']) ?></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        <?php else : ?>
            <div class="card-header">
                <h2 class="card-title"><?= htmlspecialchars($atividade['tituloAtv']) ?> (#<?= $atividade['idAtv'] ?>)</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <span class="badge bg-warning text-dark"><?= htmlspecialchars($atividade['statusAtv']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Projeto ID:</strong>
                        <span><?= $atividade['fk_Projeto_idProj'] ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Data de Início:</strong>
                        <span><?= htmlspecialchars($atividade['dataIniAtv']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Data de Término:</strong>
                        <span><?= htmlspecialchars($atividade['dataFimAtv']) ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Descrição:</strong>
                    <p class="text-muted"><?= htmlspecialchars($atividade['descricaoAtv']) ?></p>
                </div>
                <div class="mb-3">
                    <strong>Participantes:</strong>
                    <?php if (!empty($atividade['participantes'])): ?>
                        <ul class="list-group">
                            <?php foreach ($atividade['participantes'] as $participante): ?>
                                <li class="list-group-item"><?= htmlspecialchars($participante['nome']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Nenhum participante encontrado.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($docente) : ?>
        <h4><strong>Participantes:</strong></h4>
        <table class="tablecontent">
            <thead>
                <tr class="table-row">
                    <th class="table-head">Nome</th>
                    <th class="table-head">Matrícula</th>
                    <th class="table-head">E-mail</th>
                    <th class="table-head">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($atividade['participantes'] as $participante) : ?>
                    <tr class="table-row">
                        <td class="table-data"><?= htmlspecialchars($participante['nome']) ?></td>
                        <td class="table-data"><?= htmlspecialchars($participante['matricula']) ?></td>
                        <td class="table-data"><?= htmlspecialchars($participante['email']) ?></td>
                        <td class="table-data">
                            <button type="button" class="btn-success" onclick="abrirModalConfirmacao(<?= $participante['idMatricula'] ?>, <?= $atividade['idAtv'] ?>)">
                                <i class="bi bi-x-circle"></i> Remover
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <div class="text-end mt-4">
                <button type="button" class="login-btn mb-5" data-bs-toggle="modal" data-bs-target="#adicionarParticipante">
                    Adicionar Participante
                </button>
            </div>
    <?php endif; ?>
</div>


<?= $this->insert('includes/modalAddDiscenteAtv') ?>
<?= $this->insert('includes/modalFimParticipacao') ?>
<script type="module" src="/public/assets/js/Controllers/Atividade.js"></script>




