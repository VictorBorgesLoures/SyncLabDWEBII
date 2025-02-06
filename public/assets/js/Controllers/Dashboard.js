const ctx = document.getElementById('myChart');

window.onload = () => {

    let sidebarIsOpen = true;

    document.getElementById("sidebar-btn").onclick = (event => {
        event.preventDefault();
        if (!sidebarIsOpen) {
            document.getElementById("side-navbar").className = "side-bar active";
            document.getElementById("main-content").className = "main-content active";
            let logoElements = document.getElementsByClassName("navlogo");
            let length = logoElements.length;
            for (let i = 0; i < length; i++) {
                let element = logoElements[i];
                let classes = element.className.split(" ");
                element.className = "";
                for (let j = 0; j < classes.length - 1; j++) {
                    element.className += " " + classes[j];
                }
            }
        } else {
            document.getElementById("side-navbar").className = "side-bar";
            document.getElementById("main-content").className = "main-content";
            let logoElements = document.getElementsByClassName("navlogo");
            for (let i = 0; i < logoElements.length; i++) {
                logoElements[i].className += " active";
            }
        }
        sidebarIsOpen = !sidebarIsOpen;
    });

    fetch('/gerarGrafico', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(jsonData => {
        const datasetProjeto = jsonData.datasetProjeto;
        const datasetAtividade = jsonData.datasetAtividade;
        const datasetRequisicoes = jsonData.datasetRequisicoes;

        const datas = {
            proj: datasetProjeto,
            atv: datasetAtividade,
            req: datasetRequisicoes
        }

        const data = {
            labels: [
                'Janeiro', 'Fevereiro', 'Março', 'Abril',
                'Maio', 'Junho', 'Julho', 'Agosto',
                'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ].slice(0, new Date().getMonth() + 1),
            datasets: [
                datasetProjeto
            ]
        };

        const stackedLine = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        stacked: false
                    }
                }
            }
        });

        let inputs = document.getElementsByClassName('filter-option');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('change', e => {
                if (inputs[i].checked) {
                    stackedLine.data.datasets.push(datas[inputs[i].value]);
                } else {
                    for (let d in stackedLine.data.datasets) {
                        if (stackedLine.data.datasets[d].id === inputs[i].value) {
                            stackedLine.data.datasets.splice(d, 1);
                            break;
                        }
                    }
                }
                stackedLine.update();
            });
        }
    })
    .catch(error => {
        console.error("Erro ao buscar dados do gráfico: ", error);
    });
};
