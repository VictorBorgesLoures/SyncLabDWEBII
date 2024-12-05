<?php

namespace cefet\Adequa\Helper;

class MessagesHTML
{
    public static function getConformidadeMessage($conformidade, $questId, $nomeSoftware, $finalizacao = false): string
    {
        $message = "";

        if ($conformidade <= 10) {
            $message = "<p class=\"nao-conformidade\">O questionário LGPD <strong>(#$questId)</strong> do software <strong>$nomeSoftware</strong> aparenta estar em NÃO CONFORMIDADE GRAVE com a Lei Geral de Proteção de Dados, com base em nossa metodologia.
                    <br><br>É necessário tomar medidas urgentes para adequação.
                    ";
        } elseif ($conformidade <= 25) {
            $message = "<p class=\"nao-conformidade\">O questionário LGPD <strong>(#$questId)</strong> do software <strong>$nomeSoftware</strong> aparenta estar em NÃO CONFORMIDADE com a Lei Geral de Proteção de Dados, com base em nossa metodologia.
                    <br><br>.
                   ";
        } elseif ($conformidade <= 50) {
            $message = "<p class=\"parcial-conformidade\">O questionário LGPD <strong>(#$questId)</strong> do software <strong>$nomeSoftware</strong> aparenta estar em CONFORMIDADE PARCIAL BAIXA com a Lei Geral de Proteção de Dados, com base em nossa metodologia.
                    <br><br>Há vários aspectos que precisam ser revisados. 
                   ";
        } elseif ($conformidade <= 75) {
            $message = "<p class=\"parcial-conformidade\">O questionário LGPD <strong>(#$questId)</strong> do software <strong>$nomeSoftware</strong> aparenta estar em CONFORMIDADE PARCIAL ALTA com a Lei Geral de Proteção de Dados, com base em nossa metodologia.
                    <br><br>
                    ";
        } elseif ($conformidade <= 90) {
            $message = "<p class=\"em-conformidade\">O questionário LGPD <strong>(#$questId)</strong> do software <strong>$nomeSoftware</strong> aparenta estar QUASE EM CONFORMIDADE com a Lei Geral de Proteção de Dados, com base em nossa metodologia.
                    <br><br>Ainda restam alguns ajustes a serem feitos.
                    ";
        } elseif ($conformidade < 100) {
            $message = "<p class=\"em-conformidade\">O questionário LGPD <strong>(#$questId)</strong> do software <strong>$nomeSoftware</strong> aparenta estar em CONFORMIDADE com a Lei Geral de Proteção de Dados, com base em nossa metodologia.
                    Mas ainda pode existir alguma parte da legislação que o seu software não está de acordo.
                    <br><br>
                    ";
        } else{
            $message = "<p class=\"em-conformidade\">O questionário LGPD <strong>(#$questId)</strong> do software <strong>$nomeSoftware</strong> aparenta estar em CONFORMIDADE com a Lei Geral de Proteção de Dados, com base em nossa metodologia.
                    <br><br>
                    ";
        }
        if($finalizacao)
            $message = $message . "Clique em Gerar Relatório para baixar suas respostas e visualizar as tarefas necessárias para adequação. Clique 'Finalizar' para voltar à página inicial (Você poderá gerar
                    o relatório mais tarde)</p>";
        else $message = $message . "</p>";

        return $message;
    }

}