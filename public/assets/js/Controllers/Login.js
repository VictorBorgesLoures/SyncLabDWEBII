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
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },
            {
                id: 'password',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório')
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


            const response = await fetch('/login', {
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