import Form from '../Model/Form.js';
import Toast from "../Model/Toast.js";
import ValidatorRegex from '../Validators/ValidatorRegex.js';
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
            },
            {
                id: 'statusAtv',
                validators: [
                    new ValidatorRequired('Este campo é obrigatório')
                ]
            },

        ],
        onSubmit: async e => {
            e.preventDefault();

            const formId = formData.id;
            const form = document.getElementById(formId);
            const elements = form.elements;
            let formValues = {};

            for (let element of elements) {
                if (element.name) {
                    formValues[element.name] = element.value;
                }
            }

            const response = await fetch(`/atualizar-atividade`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formValues)
            });

            const data = await response.json();
            if (!data.error) {
                toast.notify("Sucesso ao atualizar atividade");
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                toast.notify("Algo de errado ocorreu");
            }
        }
    };

    let formAtualizarAtividade = new Form(formData);


    let usuarios = [
        { idMat: 1, nome: "João Silva", matriculaMat: "12345" },
        { idMat: 2, nome: "João Oliveira", matriculaMat: "67890" },
    ];

    const inputPesquisa = document.getElementById('nomeUsuario');
    const resultadosTbody = document.getElementById('resultados');

    function filtrarUsuarios(termo) {
        return usuarios.filter(usuario => {
            const termoInt = parseInt(termo);
            if (isNaN(termoInt)) {
                return usuario.nome.toLowerCase().includes(termo.toLowerCase());
            }
            return usuario.matriculaMat.toString().includes(termo);
        });
    }

    async function adicionarUsuario(idMat) {
        try {
            const url = `/atividade/adicionar-participante/${window.location.pathname.split("/").at(-1)}`;

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ idMat })
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error('Erro ao adicionar participante:', errorData.message || response.statusText);
                return;
            }

            const toast = new Toast();
            const data = await response.json();
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                toast.notify('Participante Adicionado');
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
            });
        });
    }

    inputPesquisa.addEventListener('input', function () {
        const termo = inputPesquisa.value.trim();
        if (termo.length === 0) {
            resultadosTbody.innerHTML = '';
            return;
        }

        const resultados = filtrarUsuarios(termo).slice(0, 10); // Limita a 10 resultados
        exibirResultados(resultados);
    });

    async function carregarUsuarios() {
        try {
            const response = await fetch(`/atividade/listar-possiveis-participantes/${window.location.pathname.split("/").at(-1)}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return;
            }

            const data = await response.json();
            if (!data.error) {
                usuarios = data.data; // Atualiza a lista de usuários
            }

        } catch (error) {
            console.error('Erro de requisição:', error);
        }
    }

    document.getElementById('adicionarParticipante').addEventListener('shown.bs.modal', carregarUsuarios);

    //modal finalozaçao
    let matriculaId = null;
    let atvId = null;

    window.abrirModalConfirmacao = function(matricula, atv) {
        matriculaId = matricula;
        atvId = atv;
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
            if (matriculaId && atvId) {
                try {
                    let url = `/atividade/remover-participacao`;

                    let response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ matriculaId: matriculaId, atvId: atvId }),
                    });

                    let responseData = await response.json();
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

};