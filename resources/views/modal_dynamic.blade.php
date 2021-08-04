<div class="modal" tabindex="-1" role="dialog" id="agendamentosModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <form action="/clients/calendar" method="post">
            @csrf
            <input type="hidden" name="client_id" id="clientId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info">Atendimentos ao cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- content will be load here -->
                    <div id="dynamic-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnFechaModal">Fechar</button>
                    <button type="submit" class="btn btn-primary d-none" id="btnSalvarAtendimento">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>
