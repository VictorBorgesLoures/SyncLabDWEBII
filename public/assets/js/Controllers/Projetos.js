import Form from '../Model/Form.js';
import ValidatorRegex from '../Validators/ValidatorRegex.js'
import ValidatorRequired from '../Validators/ValidatorRequired.js';

window.onload = () => {
    let formData = {
        id: "projeto-form",
        fields: [
            {
                id: 'nomeProj',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório'),
                    new ValidatorRegex(/^[A-Za-zÀ-ÿ]+(?:[A-Za-zÀ-ÿ]+\s?){5,254}$/, "Deve possuir entre 5 e 254 caracteres")
                ]
            },
            {
                id: 'descricaoProj',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório'),
                    new ValidatorRegex(/^[\da-zA-Zá-úÁ-Úà-ùÀ-ÙãõâêîôûçÇ\s.,!?;:()'"-]{40,1000}$/, "Deve possuir entre 40 e 1000 caracteres")
                ]
            }
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


            const response = await fetch('/projetos', {
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

    let formRegister = new Form(formData);



}