<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Arnaldo</title>

    <!-- <link rel="stylesheet" href="site.css"/> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Arnaldo Cabeleireio</h1>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Atendimentos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="showCalendarBySeason('weekly')">Semana</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="showCalendarBySeason('monthly')">Mês</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#filterAtendimentos" data-backdrop="static">Por Período</button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <a href="/clients" type="button" class="btn btn-primary btn-block">Novo Atendimento</a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="urlCalendarSeason" value="{{ env('APP_URL') . '/calendars?season=' }}">
        <div id="calendar-by-season">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/js/site.js"></script>

    <div class="modal" tabindex="-1" role="dialog" id="filterAtendimentos">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/clients/calendar" method="post">
                @csrf
                <input type="hidden" name="client_id" id="clientId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-info">Período dos atendimentos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="dtInicial">Data inicial</label>
                                <input class="form-control date" type="text" name="dtInicial" id="dtInicial">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="dtFinal">Data final</label>
                                <input class="form-control date" type="text" name="dtFinal" id="dtFinal">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary d-none" data-dismiss="modal" id="btnFechaModal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="showCalendarBySeason('custom')" data-dismiss="modal">Atendimentos</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
