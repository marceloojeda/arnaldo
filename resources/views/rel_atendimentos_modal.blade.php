<div class="modal" tabindex="-1" role="dialog" id="agendamentosModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info">Atendimentos {{ $dataView['filtro'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataView['results'] as $item)
                        <tr id="{{ $item->id }}">
                            <td>{{ $item->data->format('d/m/Y') }}</td>
                            <td>{{ $item->client->nome ?? '' }}</td>
                            <td class="text-right">@money($item->valor)</td>
                            <td>{{ $item->observacao }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right">Total: <b> @money($dataView['total']) </b></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnFechaModal">Fechar</button>
                <button type="submit" class="btn btn-primary d-none" id="btnSalvarAtendimento">Salvar</button>
            </div>
        </div>
    </div>
</div>
