import Toast from "../Model/Toast.js";
window.addEventListener("load", async () => {

    const toast = new Toast();

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
                    toast.notify("Participação atualizada com sucesso!");
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
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
            const url = `adicionar-integrante/${window.location.pathname.split("/").at(-1)}`;

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ idMat })
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error('Erro ao adicionar novo integrante:', errorData.message || response.statusText);
                return;
            }

            const toast = new Toast();
            const data = await response.json();
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                toast.notify('Integrante Adicionado');
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
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

        let btnAdicionar = document.querySelectorAll(".adicionar-usuario");
        btnAdicionar.forEach(botao => {
            botao.addEventListener('click', async e => {
                e.preventDefault();
                let current = e.target;
                let idMat = current.getAttribute('data-idMat');
                await adicionarUsuario(idMat);
            })
        })
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
        const response = await fetch(`listar-possiveis-integrantes/${window.location.pathname.split("/").at(-1)}`, {
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

    let participanteId = null;

    window.abrirModalConfirmacao = function(matriculaId) {
        participanteId = matriculaId;
        let modalElement = document.getElementById('confirmarFinalizacaoModal');

        if (modalElement) {
            let modal = new bootstrap.Modal(modalElement, { backdrop: 'static' });
            modal.show();
        } else {
            console.error("Modal não encontrado no DOM!");
        }
    };



    let confirmarBtn = document.getElementById('confirmarFinalizacaoBtn');

    if (confirmarBtn) {
        confirmarBtn.addEventListener('click', async function () {
            if (participanteId) {
                try {
                    let url = `/finalizar-participacao/${window.location.pathname.split("/").at(-1)}`;

                    let response = await fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ matriculaId: participanteId }),
                    });

                    let responseData = await response.json(); // Converter resposta para JSON
                    if (response.ok && !responseData.error) {
                        let modalElement = document.getElementById('confirmarFinalizacaoModal');
                        let modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();

                        const toast = new Toast();
                        if (responseData.message) {
                            toast.notify(responseData.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        }

                    } else {
                        console.error("Erro:", responseData.message || "Erro desconhecido");
                        alert(responseData.message || "Erro ao finalizar a participação. Tente novamente.");
                        window.location.reload();
                    }
                } catch (error) {
                    console.error("Erro na requisição:", error);
                    alert("Erro ao conectar ao servidor. Tente novamente.");
                }
            }
        });
    }



});



