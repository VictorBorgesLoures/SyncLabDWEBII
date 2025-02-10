<div class="modal fade" id="adicionarParticipante" tabindex="-1" aria-labelledby="adicionarParticipante" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pesquisaUsuarioModalLabel">Inserir Discente à Atividade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="formPesquisaUsuario" class="mb-5">
                    <div class="mb-3">
                        <label for="nomeUsuario" class="form-label">Nome do Usuário ou Matrícula</label>
                        <input type="text" class="form-control" id="nomeUsuario" placeholder="Digite o nome do usuário ou matrícula">
                    </div>

                </form>
                <table class="tablecontent">
                  <thead>
                    <tr class="table-row">
                      <th class="table-head">Nome</th>
                      <th class="table-head">Matrícula</th>
                      <th class="table-head">Adicionar</th>
                    </tr>
                  </thead>
                  <tbody id="resultados"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
