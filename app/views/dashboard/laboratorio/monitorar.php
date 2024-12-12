<?php $this->layout('masterApp', ['title' => 'Laboratório 6-115']);
\cefet\SyncLab\classes\Session::set('active', 'laboratorios');

/**
 * @var array $laboratorio Laboratório a ser monitorado
 */

$numPeople = rand(1, $laboratorio['numPessoas'])  //teste

?>
<div id="main-content" class="main-content active">
    <h2>Laboratório <?= $laboratorio['nomeLab']?></h2>
    <div class="cards-container">
        <div class="card-box">
            <div class="card-title">
                <h3>Status</h3>
            </div>
            <div class="card-content">
                <p>Funcionando</p>
            </div>
        </div>
        <div class="card-box">
            <!-- Talvez implementar com js um fetch para que de tempo em tempo atualize a lista sem precisar que o usuario fique dando refresh-->
            <div class="card-title">
                <h3>Pessoas - <?= $numPeople ?></h3>
            </div>
            <div class="card-content">
                <?php
                for ($i = 1; $i <= $numPeople; $i++) {
                    echo '<p>' . "Fulano $i" . '</p>';
                }
                ?>

            </div>
        </div>
    </div>
</div>
