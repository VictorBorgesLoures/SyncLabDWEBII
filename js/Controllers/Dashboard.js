const ctx = document.getElementById('myChart');

const datasetProjeto = {
    id: 'proj',
    label: '# de Projetos Ativos',
    data: [3, 9, 9, 11, 10, 8],
    borderColor: 'rgb(75, 192, 192)',
    borderWidth: 1
}

const datasetAtividade = {
    id: 'atv',
    label: '# de Atividades Realizadas',
    data: [14, 66, 32, 54, 21, 32],
    borderColor: 'rgb(75, 2, 3)',
    borderWidth: 1
}

const datasetRequisicoes = {
    id: 'req',
    label: '# de Requisições Concluídas',
    data: [2, 4, 13, 2, 1, 0],
    borderColor: 'rgb(2, 4, 66)',
    borderWidth: 1
}

const datas = {
    proj: datasetProjeto,
    atv: datasetAtividade,
    req: datasetRequisicoes
}

const data = {
    labels: ['Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro'],
    datasets: [
        datasetProjeto
    ]
}

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

    let inputs = document.getElementsByClassName('filter-option')
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('change', e => {
            if (inputs[i].checked) {
                stackedLine.data.datasets.push(datas[inputs[i].value])
            } else {
                for (let d in stackedLine.data.datasets) {
                    if (stackedLine.data.datasets[d].id == inputs[i].value) {
                        stackedLine.data.datasets.splice(d, 1);
                    }
                }
            }
            stackedLine.update();
        })
    }
}