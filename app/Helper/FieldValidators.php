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
            "regex" => '/^\d{8}$/',
            "message" => "Formato de CEP inválido. Deve possuir 8 dígitos, sem pontos ou traços"
        ],

        "complement" => [
            "regex" => '/^[\w\s.,/()[\]-]{1,255}$/',
            "message" => "Formato inválido"
        ],

        "data" => [
            "regex" => '/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/',
            "message" => "Deve possuir o formato AAAA-MM-DD"
        ],

        "username" => [
            "regex" => '/^[a-z][a-z0-9_]{1,50}$/',
            "message" => "Formato inválido. Deve começar com uma letra minúscula, pode conter números e '_' e ter até 80 caracteres."
        ],


        "password" => [
            "regex" => '/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[@$!%*?&#+()\-=\\{}~\[\]´`])[A-Za-z0-9@$!%*?&#+()\-=\\{}~\[\]´`]{8,80}$/',
            "message" => "Deve possuir entre 8 e 40 caracteres, apenas números e letras"
        ],

        "confirm-password" => [
            "regex" => '/[\d\w]{8,40}/',
            "message" => "Deve possuir entre 8 e 40 caracteres, apenas números e letras"
        ],

        "nome" => [
            "regex" => '/^[A-Za-zÀ-ÿ]+(?: [A-Za-zÀ-ÿ]+){0,150}$/',
            "message" => "Formato inválido"
        ],

        "matricula" => [
            "regex" => '/^\d{9,15}$/',
            "message" => "Deve possuir entre 9 e 15 dígitos numéricos"
        ],

        "cpf" => [
            "regex" => '/^\d{11}$/',
            "message" => "Deve possuir examatente 11 dígitos (apenas números)",
            "validateFunction" => 'validateCpf'
        ],

        "matriculaType" => [
            "regex" => '/[1-3]/',
            "message" => "Tipo de matrícula inválido"
        ],

        "nomeProj" => [
            "regex" => '/^[A-Za-zÀ-ÿ0-9\-.,]{1,50}(?:\s[A-Za-zÀ-ÿ0-9\-.,]{1,50}){1,49}$/',
            "message" => "Nome para o projeto está em formato inválido!"
        ],

        "descricaoProj" => [
            "regex" => '/^[\da-zA-Zá-úÁ-Úà-ùÀ-ÙãõâêîôûçÇ\s.,!?;:()\'"-]{40,5000}$/',
            "message" => "Descrição para o projeto está em formato inválido!"
        ]
    ];

    public static function validate($field, $data)
    {
        if (!array_key_exists($field, self::$inputRegex)) {
            return "Deve ser passado um campo válido";
        }

        if (!preg_match(self::$inputRegex[$field]["regex"], $data)) {
            return self::$inputRegex[$field]["message"];
        }

        if (array_key_exists("validateFunction", self::$inputRegex[$field])) {
            if (!self::validateCpf($data)) {
                return "Campo inválido";
            }
        }

        return true;
    }


    private static function validateCpf($cpf): bool
    {
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += intval($cpf[$c]) * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;

            if (intval($cpf[$t]) !== $d) {
                return false;
            }
        }

        return true;
    }

}
