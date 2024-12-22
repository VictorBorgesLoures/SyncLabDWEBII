import Form from '../Model/Form.js';
import ValidatorRegex from '../Validators/ValidatorRegex.js'
import ValidatorStrMinLen from '../Validators/ValidatorStrMinLen.js';
import ValidatorRequired from '../Validators/ValidatorRequired.js';
import ValidatorEnum from '../Validators/ValidatorEnum.js';

window.onload = () => {
    let formData = {
        id: "requisitar-matricula-form",
        fields: [
            {
                id: 'matricula',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório'),
                    new ValidatorRegex(/^\d{9,12}$/, "Deve possuir entre 9 e 12 números")
                ]
            },
            {
                id: 'tipo',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório'),
                    new ValidatorEnum(['1','2','3'], "Os valores aceitos são 'admin', 'docente' e 'discente'.")
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

            const response = await fetch('/matricula/requisitar', {
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

    let formRequisitar = new Form(formData);

}