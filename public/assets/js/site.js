$(document).on('click', '#openCalendar', function(e) {

    e.preventDefault();

    const client = e.currentTarget.parentNode.parentNode;
    const url = 'clients/' + client.getAttribute('data-id');

    $('#dynamic-content').html('');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html'
    })
    .done(function(data){
        $('#dynamic-content').html('');
        $('#dynamic-content').html(data);

        const clientId = document.getElementById("clientId");
        clientId.value = client.getAttribute('data-id');
    })
    .fail(function(){
        $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
    });

});

$(document).on('click', '#openCalendarForm', function(e) {
    const client = e.currentTarget.parentNode.parentNode;
    initModal(client.getAttribute('data-id'), true);
});

$(document).on("keypress", ".date", function(e) {
    const txtData = e.currentTarget;
    const dataFormatada = formatDate(txtData.value);
    txtData.value = dataFormatada;
});

function formatDate(date) {
    if(date.length == 2 || date.length == 5) {
        return date + '/';
    }
    return date;
}

function initModal(clientId = 0, showForm = false) {

    const atendimentos = document.getElementById("atendimentos");
    const btnFechaModal = document.getElementById("btnSalvarAtendimento");
    const formAtendimento = document.getElementById("form-atendimento");
    const btnSalvarAtentimento = document.getElementById("btnSalvarAtendimento");


    if(showForm) {
        atendimentos.classList.add("d-none");
        btnFechaModal.classList.add("d-none");
        formAtendimento.classList.remove("d-none");
        btnSalvarAtentimento.classList.remove("d-none");
    } else {
        atendimentos.classList.remove("d-none");
        btnFechaModal.classList.remove("d-none");
        formAtendimento.classList.add("d-none");
        btnSalvarAtentimento.classList.add("d-none");
    }
}

function getDataAtual() {
    const dataAtual = new Date;
    const dia = dataAtual.getDate() < 10 ? '0' + dataAtual.getDate() : dataAtual.getDate();
    const mes = dataAtual.getMonth() < 10 ? '0' + dataAtual.getMonth() : dataAtual.getMonth();
    const ano = dataAtual.getFullYear();

    return dia + '/' + mes + '/' + ano;
}

function showCalendarBySeason(season) {
    $.ajax({
        url: document.getElementById('urlCalendarSeason').value + season ,
        type: 'GET',
        dataType: 'html'
    })
    .done(function(data){
        $('#calendar-by-season').html('');
        $('#calendar-by-season').html(data);

        $('#agendamentosModal').modal('show');

        // const clientId = document.getElementById("clientId");
        // clientId.value = client.getAttribute('data-id');
    })
    .fail(function(){
        $('#calendar-by-season').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
    });
}