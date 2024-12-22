<?php

namespace cefet\SyncLab\Helper;

class FieldValidators
{
    private static array $inputRegex = [
        "id" => [
            "regex" => '/\d{1,11}/',
            "message" => "Deve possuir entre 1 e 11 dígitos"
        ],

        "email" => [
            "regex" => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            "message" => "Formato de email inválido"
        ],

        "address" => [
            "regex" => '/^[\p{L}\p{N}\s]*/',
            "message" => "Formato de rua inválido"
        ],

        "number" => [
            "regex" => '/^\d{1,11}$/',
            "message" => "Deve possuir entre 1 e 11 dígitos"
        ],

        "cep" => [
            "regex" => '/^\d{5}-?\d{3}$/',
            "message" => "Formato inválido"
        ],

        "complement" => [
            "regex" => '/^[\w\s.,/()[\]-]{1,255}$/',
            "message" => "Formato inválido"
        ],

        "data" => [
            "regex" => '/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/',
            "message" => "Deve possuir o formato DD-MM-AA"
        ],

        "username" => [
            "regex" => '/^[A-Za-z]{1,100}(? =>_[A-Za-z]{1,100}){0,99}$/',
            "message" => "Formato inválido, deve possuir apenas letras minúsculas, sem acento e sem espaço entre elas"
        ],

        "password" => [
            "regex" => '/[\d\w]{8,40}/',
            "message" => "Deve possuir entre 8 e 40 caracteres, apenas números e letras"
        ],

        "confirm-password" => [
            "regex" => '/[\d\w]{8,40}/',
            "message" => "Deve possuir entre 8 e 40 caracteres, apenas números e letras"
        ],

        "nome" => [
            "regex" => '/^[A-Za-zÀ-ÿ]+(?:[A-Za-zÀ-ÿ]+){0,254}$/',
            "message" => "Formato inválido"
        ],

        "matricula" => [
            "regex" => '/^\d{9,15}$/',
            "message" => "Deve possuir entre 9 e 15 dígitos numéricos"
        ],

        "cpf" => [
            "regex" => '/^\d{11}$/',
            "message" => "Deve possuir examatente 11 dígitos (apenas números)"
        ],

        "matriculaType" => [
            "regex" => '/[1-3]/',
            "message" => "Tipo de matrícula inválido"
        ]
    ];

    public static function validate($field, $data)
    {
        if (array_key_exists($field, self::$inputRegex)) {
            if (!preg_match(self::$inputRegex[$field]["regex"], $data)) {
                return self::$inputRegex[$field]["message"];
            }
        } else {
            return "Deve ser passado um campo válido";
        }

        return true;
    }
}
