<?php $this->layout("masterApp", ["title" => "Atividades do Projeto"]);
\cefet\SyncLab\classes\Session::set('active', 'projetos');

/**
 * @var array $atividades acoes necessarias para os projetos
 */

?>
<div id="main-content" class="main-content active">
    
<?php
    $this->insert('includes/toasts');
    echo \cefet\SyncLab\classes\Session::messageFlash();
    
    ?>
        <form class="form" id="atividade-form">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Nova Atividade</h2>
            </div>
            <div class="form-group">
                <label class="label-box">Título:</label>
                <input class="input-box" id="tituloAtv" name="tituloAtv" type="text" placeholder="Digite o titulo da atividade." />
            </div>
            <div class="form-group">
                <label class="label-box">Descrição:</label>
                <textarea class="input-box" id="descricaoAtv" name="descricaoAtv" type="text" placeholder="Descreva em até 1000 caracteres a atividade." ></textarea>
            </div>
            <div class="form-group">
                <label class="label-box">Data Entrega:</label>
                <input class="input-box" id="dataFimAtv" name="dataFimAtv" type="date" placeholder="dd/mm/aaaa" />
            </div>
        <?php
        if (\cefet\SyncLab\classes\Session::get('type') == 'docente'):
        ?>
            <div class="text-end">
                <button class="login-btn mb-5" id="adicionar-atv" type="submit">Adicionar Atividade</button>
            </div>
        </form>
        <?php        
        elseif (\cefet\SyncLab\classes\Session::get('type') == 'discente'):
            ?>
            <div class="text-end">
                <button class="login-btn mb-5" id="requisitar-atv" type="submit">Requisitar Atividade</button>
            </div>
        <?php 
        endif
        ?>
        
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

<script type="module" src="/public/assets/js/Controllers/Atividades-Proj.js"></script>
