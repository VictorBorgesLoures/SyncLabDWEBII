import Form from '../Model/Form.js';
import ValidatorRegex from '../Validators/ValidatorRegex.js'
import ValidatorStrMinLen from '../Validators/ValidatorStrMinLen.js';
import ValidatorRequired from '../Validators/ValidatorRequired.js';

window.onload = () => {
    let formData = {
        id: "login-form",
        fields: [
            {
                id: 'username',
                validators: [
                    new ValidatorRegex(/^\w+$/, "Deve possuir apenas letras minúsculas e maiúsculas sem acento!"),
                    new ValidatorStrMinLen(3, "Deve possuir ao menos 3 caracteres"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'password',
                validators: [
                    new ValidatorRegex(/^\w+$/, "Deve possuir apenas letras minúsculas e maiúsculas sem acento!"),
                    new ValidatorStrMinLen(6, "Deve possuir ao menos 6 caracteres"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            }
        ],
        onSubmit: e => {
            e.preventDefault();
            window.location.href = '/dashboard'
        }
    }

    let form = new Form(formData);

}