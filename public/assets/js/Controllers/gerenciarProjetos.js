window.addEventListener("load", () => {
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
    const usuarios = [
        { id: 1, nome: "João Silva", matricula: "12345" },
        { id: 2, nome: "João Oliveira", matricula: "67890" },
    ];

    const inputPesquisa = document.getElementById('nomeUsuario');
    const resultadosTbody = document.getElementById('resultados');

    function filtrarUsuarios(termo) {
    return usuarios.filter(usuario =>
        usuario.nome.toLowerCase().includes(termo.toLowerCase())
    );
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
                <td>${usuario.matricula}</td>
                <td>
                  <button class="btn btn-success btn-sm" onclick="adicionarUsuario('${usuario.nome}', '${usuario.matricula}')">
                    Adicionar
                  </button>
                </td>
            `;
            resultadosTbody.appendChild(row);
        });
    }

    function adicionarUsuario(nome, matricula) {
        alert(`Usuário adicionado: ${nome} (Matrícula: ${matricula})`);

    }

    inputPesquisa.addEventListener('input', function () {
        const termo = inputPesquisa.value.trim();
        if (termo.length === 0) {
            resultadosTbody.innerHTML = '';
            return;
        }

        const resultados = filtrarUsuarios(termo);
        exibirResultados(resultados);
    });
});


