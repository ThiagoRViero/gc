$(document).ready(() => {
    $.ajax({
        type: 'get',
        url: '/usernames',
        dataType: 'json',
        error: () => { return "Usuários não localizados" },
        success: r => {
            r.forEach(user => {
                $('#requester').append("<option value='" + user['US_ID'] + "'>" + user['US_NOME'] + "</option>");
            });
        }
    })

    $("#formNewTicket").submit(form => {
        form.preventDefault(form)
        userId = form.target[0].value
        description = form.target[1].value
        ticket = {
            'user': userId,
            'description': description
        }
        $.ajax({
            type: 'post',
            url: '/createTicket',
            data: ticket,
            dataType: 'text',
            error: () => { return "Houve um erro na criação do seu ticket" },
            success: res => {
                if (!isNaN(res)) {
                    $('#new').attr('class', 'modal d-block')
                    $('#ticketNumber').html(res)

                    $('#newTicket').on('click', () => {
                        $('#new').attr('class', 'modal fade')
                        $('#description').val('');
                    })

                    $('#goToTicket').on('click', () => {
                        window.location.replace('/edit_ticket?id=' + res)
                        $(window).redirect('/edit_ticket?id=' + res)
                    })
                }

                console.log(res);
            }
        })


    })


})