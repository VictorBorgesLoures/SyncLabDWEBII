<?php

namespace cefet\SyncLab\Helper;

$inputRegex = [
    "id" => /\d{1,11}/,
    "email"  => /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    "rua" => /^[\p{L}\p{N}\s]*/,
    "numero" => /^\d{1,11}$/,
    "cep" => /^\d{5}-?\d{3}$/,
    "complemento" => /^[\w\s.,/()[\]-]{1,255}$/,
    "data" => /^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/,
    "username" => /^[A-Za-z]{1,100}(? =>_[A-Za-z]{1,100}){0,99}$/,
    "password" => /[\d\w]{8,40}/,
    "nome" => /^[A-Za-zÀ-ÿ]+(?:[A-Za-zÀ-ÿ]+){0,254}$/,
    "matricula" => /^\d{9,15}$/,
    "cpf" => /^\d{11}$/,
    "matricula" => /^\d{9,15}$/,
    "matriculaType" => /[1-3]/
];

class FieldValidator {

    public static validade($field, $data) {
        if($inputRegex[$field]) {
            if (!preg_match($inputRegex[$field], $data)) {
                return "A senha deve incluir pelo menos 8 caracteres entre letras e números.";
            }
        } else {
            return "Deve ser passado um campo válido";
        }
    }  

}


?>