@extends('layout')
@section('conteudo')

<div class="row">
    <div class="col-6">
        <h2 class="card-title m-2">Clientes</h2>
    </div>
    <div class="col-6 text-right">
        <a href="/clients/create" class="btn btn-sm btn-primary m-2">Novo Cliente</a>
    </div>
</div>
<table class="table table-responsive">
    <thead>
        <tr>
            <th class="col-4">Nome</th>
            <th class="col-2">Telefone</th>
            <th class="col-3">Bairro</th>
            <th class="col-2" colspan="2">
                <form action="/clients" method="GET">
                    <input class="form-control" type="text" name="nome" id="txtPesquisa" placeholder="nome do cliente">
                </form>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
        <tr data-id="{{ $client->id }}">
            <td>{{ $client->nome }}</td>
            <td>{{ $client->fone }}</td>
            <td>{{ $client->bairro }}</td>
            <td CLASS="text-right">
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agendamentosModal">
                    Agendamentos
                </button> -->
                <button data-toggle="modal" data-target="#agendamentosModal" id="openCalendar" class="btn btn-sm btn-info">
                    Atendimentos
                </button>
            </td>
            <td class="text-right">
                <a href="/clients/{{ $client->id }}/edit" class="btn btn-danger float-warning">Alterar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@include('modal_dynamic')
@stop
