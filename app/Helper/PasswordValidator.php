<?php

namespace cefet\SyncLab\classes;
class PasswordValidator
{
    public static function validate($password): true|string
    {
        // Verifica o comprimento da senha
        if (strlen($password) < 8 || strlen($password) > 80) {
            return "A senha deve ter entre 8 a 80 caracteres.";
        }

        // Verifica a presença de pelo menos um dígito
        if (!preg_match('/[0-9]/', $password)) {
            return "A senha deve incluir pelo menos um dígito.";
        }

        // Verifica a presença de pelo menos uma letra maiúscula
        if (!preg_match('/[A-Z]/', $password)) {
            return "A senha deve incluir pelo menos uma letra maiúscula.";
        }

        // Verifica a presença de pelo menos uma letra minúscula
        if (!preg_match('/[a-z]/', $password)) {
            return "A senha deve incluir pelo menos uma letra minúscula.";
        }

        // Verifica a presença de pelo menos um caractere especial
        if (!preg_match('/[@$!%*?&#+()\-={}~\[\]´`]/', $password)) {
            return "A senha deve incluir pelo menos um caractere especial como @, $, !, etc.";
        }

        return true;
    }
}