import Form from '../Model/Form.js';
import ValidatorRegex from '../Validators/ValidatorRegex.js'
import ValidatorStrMinLen from '../Validators/ValidatorStrMinLen.js';
import ValidatorRequired from '../Validators/ValidatorRequired.js';
import ValidatorEnum from '../Validators/ValidatorEnum.js';
import ValidatorStrMaxLen from '../Validators/ValidatorStrMaxLen.js'

window.onload = () => {
    let formData = {
        id: "contato-form",
        fields: [
            {
                id: 'nome',
                validators: [
                    new ValidatorRegex(/^[\w+]+(\s\w+)*$/, "Deve possuir apenas letras minúsculas e maiúsculas sem acento!"),
                    new ValidatorStrMinLen(3, "Deve possuir ao menos 3 caracteres"),
                    new ValidatorStrMaxLen(100, "Deve possuir no máximo 100 caracteres"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'assunto',
                validators: [
                    new ValidatorEnum(["Orçamento", "SAC", "Marketing", "Outro"], "Deve selecionar entre: Orçamento, SAC, Marketing ou Outro."),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            }, 
            {
                id: 'comentario',
                validators: [
                    new ValidatorRegex(/^[\w+]+(\s\w+)*$/, "Deve possuir apenas letras minúsculas e maiúsculas sem acento!"),
                    new ValidatorStrMinLen(100, "Deve possuir ao menos 100 caracteres"),
                    new ValidatorStrMaxLen(1000, "Deve possuir no máximo 1000 caracteres"),
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            }
        ],
        onSubmit: (e, cb) => {
            e.preventDefault();
            window.location.href = '/contato.html'
        }
    }

    let form = new Form(formData);

}