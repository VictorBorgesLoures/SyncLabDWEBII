import Toast from "../Model/Toast.js";

let toast = new Toast();

function initializeSearch() {
    $('#searchInput').on('keyup', function () {
        const input = $(this).val().trim();

        if (input.length >= 3) {
            fetchProjects(input);
        } else {
            $('#results').html('<tr><td colspan="3">Digite pelo menos 3 caracteres para buscar.</td></tr>');
        }
    });
}

function fetchProjects(searchTerm) {
    $.ajax({
        url: 'projetos/listar-possiveis-projetos',
        type: 'POST',
        data: { nomeProjeto: searchTerm },
        success: function (response) {
            if (response.error) {
                $('#results').html('<tr><td colspan="3">' + response.message + '</td></tr>');
            } else if (response.data && response.data.length > 0) {
                displayResults(response.data);
            } else {
                $('#results').html('<tr><td colspan="3">Nenhum projeto encontrado.</td></tr>');
            }
        },
        error: function () {
            $('#results').html('<tr><td colspan="3">Erro na busca. Tente novamente mais tarde.</td></tr>');
        }
    });
}

function displayResults(projects) {
    let html = '';

    projects.forEach(function (proj) {
        html += `<tr class="table-row" id="proj-${proj.idProj}">` +
            '<td>' + proj.nomeProj + '</td>' +
            '<td>' + proj.tutor + '</td>' +
            '<td>' +
            '<button class="btn-success" onclick="solicitarParticipacao(' + proj.idProj + ')">Solicitar Participação</button>' +
            '</td>' +
            '</tr>';
    });

    $('#results').html(html);
}

window.solicitarParticipacao = function (idProj) {
    const idMat = document.getElementById('idMat').value;

    const data = {
        idProj: idProj,
        idMat: idMat
    };

    fetch('projetos/solicitar-participacao-projeto', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                console.error('Erro ao enviar a solicitação de participação: ', response);
            }
            return response.json();
        })
        .then(data => {
            toast.notify('Solicitação de participação enviada com sucesso!');
            document.getElementById('proj-'+idProj).remove();
        })
        .catch(error => {
            toast.notify('Erro ao enviar a solicitação de participação.');
        });
};

$(document).ready(function () {
    initializeSearch();
});