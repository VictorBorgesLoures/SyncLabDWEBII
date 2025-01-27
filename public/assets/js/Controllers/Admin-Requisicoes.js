window.addEventListener("load", () => {

    let btnSalvar = document.getElementsByClassName("salvar-btn");
    let tipo = document.getElementById('tipoReq').attributes['data-id'].value;

    Array.from(btnSalvar).forEach(m => {
        m.onclick = async e => {
            e.preventDefault();
            let current = e.target;
            if(current.nodeName == 'IMG') {
                current = current.parentElement;
            }
            current = current.parentElement.parentElement;
            let id = current.attributes['data-id'].value;
            let status = current.children[3].children[0].value;
            let formValues = {
                id,
                status
            }

            if(formValues.statusMat == "Em análise")
                return;

            const response = await fetch('/requisicoes/'+tipo.split('-')[1], {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formValues)
            });

            const data = await response.json();
            window.location.href = data.redirect;
        }

    });

});