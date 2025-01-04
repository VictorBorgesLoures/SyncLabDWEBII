<?php $this->layout('master', ['title' => 'SyncLab - Matrícula']);
\cefet\SyncLab\classes\Session::set('active', 'login');

/**
 * @var array $listaMatriculas as matrículas pertencentes ao usuário
 */

?>

<div class="matricula-center-items">
    <div class='matricula-container'>
        <h1>Matrícula</h1>
        <div class="matricula-box">
            <?php
                if(count($listaMatriculas) == 0) {
                    echo '<button type="button" class="matricula-btn disabled">
                        Não há matrícula
                    </button>';
                } else {
                    $first = 0;
                    foreach($listaMatriculas as $matricula) { 
                        $first++;
                        $tipo = 'Admin';
                        if ($matricula["tipoMat"] == 2)
                            $tipo = 'Discente';
                        else if ($matricula["tipoMat"] == 3)
                            $tipo = 'Docente';
                        $className = "matricula-btn";
                        if($first == 1)
                            $className = $className." active";
                        echo '<button type="button" class="'.$className.'" data-id="'.$matricula["idMat"].'">
                            '.$matricula["matriculaMat"].' - '.$tipo.'
                        </button>';
                    }
                }
            ?>
        </div>
        <button type="button" class='matricula-entrar-btn' id="entrarMatricula">Entrar</button>
        <button type="button" class='matricula-entrar-btn' id="sairMatriula">Sair</button>
        <button type="button" class='matricula-solicitar-btn'>
            <a href="./matricula/requisitar" class='matricula-solicitar-btn'>Solicitar Matrícula</a>
        </button>
    </div>
</div>


<script type="module" text="javascript" src="/public/assets/js/Controllers/Matricula.js"></script>