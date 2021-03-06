<div class="row">
    <div class="col-6">
        <p>
            Nome: <b>{{ $client->nome }}</b>
        </p>
    </div>
    <div class="col-6">
        <p class="text-right">
            Telefone: <b>{{ $client->fone }}</b>
        </p>
    </div>
</div>
<div class="row" id="atendimentos">
    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Observações</th>
                    <th class="text-right"><button type="button" id="openCalendarForm" class="btn btn-sm btn-info">Novo Atendimento</button></th>
                </tr>
            </thead>
            <tbody>
                @foreach($client->atendimentos as $atendimento)
                <tr onclick="editAtendimento('{{ $atendimento->id }}')" style="cursor:pointer;">
                    <td>{{ $atendimento->data->format('d/m/Y') }}</td>
                    <td>@money($atendimento->valor)</td>
                    <td colspan="2">{{ $atendimento->observacao }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="row d-none" id="form-atendimento">
    <input type="hidden" name="calendar_id" id="calendar_id">
    <div class="form-group col-6">
        <label for="txtData">Data</label>
        <input type="input" name="data" class="form-control date" id="txtData" maxlength="10">
    </div>
    <div class="form-group col-6">
        <label for="txtValor">Valor</label>
        <input type="text" name="valor" class="form-control" id="txtValor">
    </div>
    <div class="form-group col-12">
        <textarea class="form-control" name="observacao" id="txtObs" rows="3"></textarea>
    </div>
    <div class="form-group col-12 d-none" id="divIsActive">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" name="is_active">
                </div>
            </div>
            <input type="text" class="form-control" value="Excluir esse atendimento?" disabled>
        </div>
    </div>
</div>
