window.onload = () => {

    function selecionarMatricula(e) {
        e.preventDefault();

    }

    let matriculas = document.getElementsByClassName("matricula-btn");

    Array.from(matriculas).forEach(m => {
        m.onclick = e => {
            e.preventDefault();
            if (!/active/.exec(e.target.className)) {
                Array.from(matriculas).forEach(mat => {
                    if (/active/.exec(mat.className)) {
                        mat.className = "matricula-btn";
                    }
                });
                e.target.className = "matricula-btn active";
            }
        }

    });

    document.getElementById("entrarMatricula").onclick = async e => {
        e.preventDefault();
        let matricula = document.getElementsByClassName("matricula-btn active")[0];
        let formValues = {};
        formValues['idMat'] = matricula.attributes['data-id'].value;
        if (matricula) {
            const response = await fetch('/matricula', {
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

}