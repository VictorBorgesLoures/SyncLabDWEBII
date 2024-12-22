<?php $this->layout('master', ['title' => 'SyncLab - Requisitar Matrícula']);
\cefet\SyncLab\classes\Session::set('active', 'login');
?>

<div class="matricula-center-items">
    <div class='matricula-container'>
        <h1>Solicitação de Matrícula</h1>
        <form id="requisitar-matricula-form">
            <p class="label">Número de Matricula:</p>
            <?php echo \cefet\SyncLab\classes\Session::messageFlash() ?>
            <div class="form-group">
                <input
                    class="input-box"
                    placeholder='Digite sua matrícula'
                    type="number"
                    id="matricula"
                    name="matricula"
                    required />
            </div>
            <div class="form-group">
                <p class="label" for="tipo">Tipo de Vínculo:</p>
                <select id="tipo" name="tipo">
                    <option value="1">Admin</option>
                    <option value="2">Discente</option>
                    <option value="3">Docente</option>
                </select>
            </div>
            <button class="submit-requisitar-btn">Solicitar</button>
            <a href="/matricula"><button type="button" class="submit-requisitar-btn">Voltar</button></a>
        </form>
    </div>
    <?php

    if (count($listaRequisicaoMatriculas) > 0) {
        echo "<div class='matricula-container'>
                <h2>Requisições em aberto</h2>
                <div class='matricula-box'>";

        foreach ($listaRequisicaoMatriculas as $matricula) {            
            $tipo = 'Admin';
            if ($matricula["tipoMat"] == 2)
                $tipo = 'Docente';
            else if ($matricula["tipoMat"] == 3)
                $tipo = 'Discente';
            echo '<button type="button" class="matricula-btn disabled" disabled>
                ' . $tipo. ' - ' . strval($matricula["matriculaMat"]). '
            </button>';
            
            
        }
        echo "</div>
            </div>";
    }

    ?>

</div>

<script type="module" text="javascript" src="/public/assets/js/Controllers/RequisitarMatricula.js"></script>