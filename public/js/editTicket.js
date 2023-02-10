$(document).ready(() => {
    initStat = $("#status").val()
    getUsers()

    if ($("#status").val() == '2' || $("#status").val() == '4') {
        lock()
    } else {
        unlock()
    }

    $("#status").on("change", () => {
        if ($("#status").val() == 2) {
            $("#res").attr("hidden", false)
        } else {
            $("#res").attr("hidden", true)
        }
    })

    $("#formEditTicket").submit(form => {
        form.preventDefault(form)
        id = form.target[0].value
        requestor = form.target[1].value
        attendants = form.target[2].value
        description = form.target[3].value
        stat = form.target[4].value
        resolution = form.target[5].value
        ticket = { id, requestor, attendants, description, stat, resolution }
        console.log(ticket)
        $.ajax({
            type: 'post',
            url: '/edit_ticket',
            data: ticket,
            dataType: 'text',
            error: () => { return "Houve um erro na criação do seu ticket" },
            success: res => {
                console.log(res)

                $('#divMessage').attr("hidden", false)
                $('#containerForm').addClass('mt-3')

                if (res == 1) {
                    $('#divMessage').removeClass('alert-danger')
                    $('#divMessage').addClass('alert-success')
                    $('#message').html("Ticket alterado com sucesso!");
                    if (!((initStat == '1' || initStat == '3') && (stat == '1' || stat == '3'))) {
                        initStat = stat
                        location.reload()
                    }

                } else {
                    $('#divMessage').removeClass('alert-success')
                    $('#divMessage').addClass('alert-danger')
                    $('#message').html(res);
                }

            }
        })


    })

    $("#closeMessage").on('click', () => {
        $('#containerForm').removeClass('mt-3')

    })

})

function lock() {
    $(".formInput").removeClass("bg-white")
    $(".formInput").addClass("bg-secondary")
    $(".formInput").addClass("text-white")
    $(".formInput").addClass("opacity-25")
    $(".formInput").prop("disabled", true)
    $("#res").attr("hidden", false)
}

function unlock() {


    $(".formInput").addClass("bg-white")
    $(".formInput").removeClass("bg-secondary")
    $(".formInput").removeClass("text-white")
    $(".formInput").removeClass("opacity-25")
    $(".formInput").prop("disabled", false)
    $("#res").attr("hidden", true)
}

function getUsers() {
    $.ajax({
        type: 'get',
        url: '/usernames',
        dataType: 'json',
        error: () => { return "Usuários não localizados" },
        success: r => {
            r.forEach(user => {
                if (!($('#selectedRequester').val() == user['US_ID'])) {
                    $('#requester').append("<option value='" + user['US_ID'] + "'>" + user['US_NOME'] + "</option>");
                }

                if (user['US_ACCESS'].find(element => element == 2)) {
                    $('#attendants').append("<option value='" + user['US_ID'] + "'>" + user['US_NOME'] + "</option>");
                }
            });
        }
    })
}