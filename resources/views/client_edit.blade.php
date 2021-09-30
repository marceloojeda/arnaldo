@extends('layout')
@section('conteudo')

<form action="/clients/{{ $client['id'] }}" method="post">
    @csrf
    @method('PUT')
    <input type="hidden" id="deleted_at" name="deleted_at" value="{{$client['deleted_at']}}">
    <div class="card mt-2">
        <div class="card-header bg-info text-light text-center">
            Atualização de Cadastro
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <input data-style="float-right" data-on="Ativo" data-off="Inativo" data-size="small" data-onstyle="success" data-offstyle="danger" id="is_active" type="checkbox" data-toggle="toggle" {{ $client['deleted_at'] ? '' : 'checked' }} >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-8">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" value="{{ $client['nome'] }}">
                </div>
                <div class="form-group col-sm-4">
                    <label for="fone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" name="fone" value="{{ $client['fone'] }}">
                </div>

                <div class="form-group col-sm-8">
                    <label for="referencia" class="form-label">Indicado por</label>
                    <input type="text" class="form-control" name="referencia" value="{{ $client['referencia'] }}">
                </div>
                <div class="form-group col-sm-4">
                    <label for="data_nascimento" class="form-label">Nascido em</label>
                    <input type="text" class="form-control date" name="data_nascimento" value="{{ $client['data_nascimento'] }}">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#divEndereco" aria-expanded="false" aria-controls="divEndereco">
                    Endereço
                </button>
            </div>
            <div class="collapse mt-4" id="divEndereco">
                <div class="dropdown-divider"></div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="endereco" value="{{ $client['endereco'] }}">
                    </div>
                    <div class="form-group col-sm">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" name="bairro" value="{{ $client['bairro'] }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-2">
                        <label for="uf" class="form-label">Estado</label>
                        <select name="uf" id="" class="form-control">
                            <option value="MG">Minas Gerais</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" name="cidade" value="{{ $client['cidade'] }}">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" name="cep" value="{{ $client['cep'] }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="data_adesao" class="form-label">Cliente desde</label>
                        <input type="text" class="form-control date" name="data_adesao" value="{{ $client['data_adesao'] }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-left">
                <a href="/clients" class="btn btn-secondary">Voltar</a>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</form>
@stop
