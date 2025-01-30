import Form from '../Model/Form.js';
import Toast from "../Model/Toast.js";
import ValidatorRegex from '../Validators/ValidatorRegex.js'
import ValidatorRequired from '../Validators/ValidatorRequired.js';

window.onload = () => {
    let toast = new Toast();
    let formData = {
        id: "atividade-form",
        fields: [
            {
                id: 'tituloAtv',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório'),
                    new ValidatorRegex(/^[A-Za-zÀ-ÿ]+(?:[A-Za-zÀ-ÿ]+\s?){5,254}$/, "Deve possuir entre 5 e 254 caracteres")
                ]
            },
            {
                id: 'descricaoAtv',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório'),
                    new ValidatorRegex(/^[\da-zA-Zá-úÁ-Úà-ùÀ-ÙãõâêîôûçÇ\s.,!?;:()'"-]{40,1000}$/, "Deve possuir entre 40 e 1000 caracteres")
                ]
            },
            {
                id: 'dataFimAtv',
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
            let formValues = {};
            formValues['idProj'] = window.location.pathname.split('/').at(-2);

            for (let element of elements) {
                if (element.name) {
                    formValues[element.name] = element.value;
                }
            }


            const response = await fetch(`/projetos/adicionar-atividade`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formValues)
            });

            const data = await response.json();
            if (!data.error) {
                toast.notify(data.message);
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                toast.notify(data.message);
            }
        }


    }

    let formRegistrarAtividade = new Form(formData);

}