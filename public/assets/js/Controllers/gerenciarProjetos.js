window.addEventListener("load", async () => {
    let btnSalvar = document.getElementsByClassName("req-btn");

    Array.from(btnSalvar).forEach(botao => {
        botao.onclick = async e => {
            e.preventDefault();

            let current = e.target;

            if (current.nodeName === 'IMG') {
                current = current.parentElement;
            }

            let tr = current.parentElement.parentElement;

            let id = tr.getAttribute('data-req');

            let select = tr.children[2].querySelector('select');
            let status = select.value;
            console.log(id)
            let formValues = {
                matriculaId: id.split('/')[0],
                projetoId: id.split('/')[1],
                status: status
            };


            try {
                const response = await fetch('/projetos/atualizar-participacao', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formValues)
                });

                if (!response.ok) {
                    console.error('Erro na atualização:', response.statusText);
                    return;
                }

                const data = await response.json();
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    alert('Status atualizado com sucesso!');
                }

            } catch (error) {
                console.error('Erro de requisição:', error);
            }
        };
    });

    // Pesquisa de usuários
    let usuarios = [
        { id: 1, nome: "João Silva", matricula: "12345" },
        { id: 2, nome: "João Oliveira", matricula: "67890" },
    ];

    const inputPesquisa = document.getElementById('nomeUsuario');
    const resultadosTbody = document.getElementById('resultados');

    function filtrarUsuarios(termo) {
        return usuarios.filter(usuario => {
                const termoint = parseInt(termo);
                if(isNaN(termoint)) {
                    return usuario.nome.toLowerCase().includes(termo.toLowerCase());
                }
                return usuario.matriculaMat.toString().includes(termo);
        });
    }

    async function adicionarUsuario(idMat) {
        try {
            const response = await fetch(`/projetos/${window.location.pathname.split("/").at(-1)}/adicionar-integrante`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({idMat})
            });

            if (!response.ok) {
                console.error('Erro ao idicionar novo integrante:', response.statusText);
                return;
            }

            const data = await response.json();
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert('Status atualizado com sucesso!');
            }

        } catch (error) {
            console.error('Erro de requisição:', error);
        }
    }


    function exibirResultados(resultados) {
        resultadosTbody.innerHTML = ''; // Limpa os resultados anteriores

        if (resultados.length === 0) {
            resultadosTbody.innerHTML = `
            <tr>
              <td colspan="3" class="text-center">Nenhum usuário encontrado</td>
            </tr>
            `;
            return;
        }

        resultados.forEach(usuario => {
            const row = document.createElement('tr');
            row.className = 'table-row';
            row.innerHTML = `
                <td>${usuario.nome}</td>
                <td>${usuario.matriculaMat}</td>
                <td>
                  <button class="btn btn-success btn-sm adicionar-usuario" data-idMat='${usuario.idMat}'>
                    Adicionar
                  </button>
                </td>
            `;
            resultadosTbody.appendChild(row);
        });

        let btnAdicionar = document.getElementsByClassName("adicionar-usuario");
        Array.from(btnAdicionar).forEach(botao => {
            botao.onclick = async e => {
                e.preventDefault();
                let current = e.target;
                adicionarUsuario(current.getAttribute("data-matId"));
            }
        });
    }

    inputPesquisa.addEventListener('input', function () {
        const termo = inputPesquisa.value.trim();
        if (termo.length === 0) {
            resultadosTbody.innerHTML = '';
            return;
        }

        const resultados = filtrarUsuarios(termo).slice(0, 10);
        exibirResultados(resultados);
    });

    try {
        const response = await fetch(`/projetos/${window.location.pathname.split("/").at(-1)}/listar-possiveis-integrantes`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            console.error('Erro na atualização:', response.statusText);
            return;
        }

        const data = await response.json();
        if (!data.error) {
            usuarios = data.data;
        }

    } catch (error) {
        console.error('Erro de requisição:', error);
    }
});


