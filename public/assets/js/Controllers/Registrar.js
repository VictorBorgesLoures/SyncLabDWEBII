import Form from '../Model/Form.js';
import ValidatorRegex from '../Validators/ValidatorRegex.js'
import ValidatorStrMinLen from '../Validators/ValidatorStrMinLen.js';
import ValidatorRequired from '../Validators/ValidatorRequired.js';
import ValidatorMatch from '../Validators/ValidatorMatch.js';

window.onload = () => {
    let formData = {
        id: 'registrar-form',
        fields: [
            {
                id: 'email',
                validators: [
                    new ValidatorRegex(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, "Formato de email inválido"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'address',
                validators: [
                    new ValidatorRegex(/^[a-zA-Z0-9\s]*$/, "Formato de rua inválido"),
                    new ValidatorRequired('Este campo é obrigatório')

                ]
            },
            {
                id: 'number',
                validators: [
                    new ValidatorRegex(/^\d{1,11}$/, "Deve possuir entre 1 e 11 dígitos"),
                    new ValidatorRequired('Este campo é obrigatório')

                ]
            },
            {
                id: 'cep',
                validators: [
                    new ValidatorRegex(/^\d{5}-?\d{3}$/, "Formato de CEP inválido"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'complement',
                validators: [
                    new ValidatorRegex(/^[\w\s.,/()[\]-]{1,255}$/, "Formato de complemento inválido")

                ]
            },
            {
                id: 'data',
                validators: [
                    new ValidatorRegex(/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/, "Deve possuir o formato AAAA-MM-DD"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'username',
                validators: [
                    new ValidatorRegex(/^[a-zA-Z_]{1,100}$/, "Formato inválido, deve possuir apenas letras e sublinhados"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'password',
                validators: [
                    new ValidatorRegex(/[\d\w]{8,40}/, "Deve possuir entre 8 e 40 caracteres, apenas números e letras"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'confirm-password',
                validators: [
                    new ValidatorMatch('password', 'As senhas não coincidem'),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'name',
                validators: [
                    new ValidatorRegex(/^[A-Za-zÀ-ÿ]+(?:\s[A-Za-zÀ-ÿ]+){0,254}$/, "Formato de nome inválido"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'cpf',
                validators: [
                    new ValidatorRegex(/^\d{11}$/, "Deve possuir exatamente 11 dígitos (apenas números)"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
        ],
        onSubmit: async e => {
            e.preventDefault();

            const formId = formData.id;
            const form = document.getElementById(formId);
            const elements = form.elements;
            const formValues = {};

            for (let element of elements) {
                if (element.name) {
                    formValues[element.name] = element.value;
                }
            }

            const response = await fetch('/registrar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formValues)
            });

            const data = await response.json();

            if (data.success) {
               window.location.href = data.redirect;
            } else {

               window.location.href = data.redirect;
            }
        }

    }

    let form = new Form(formData);

}