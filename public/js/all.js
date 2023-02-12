$(document).ready(() => {
    $("#searchForm").submit(form => {
        form.preventDefault()
        ticket = { 'id': form.target[0].value }
        $.ajax({
            type: 'get',
            url: '/edit_ticket',
            data: ticket,
            dataType: 'text',
            error: () => { return "Houve um erro na criação do seu ticket" },
            success: res => {
                if (res == false || res == null || res == "") {
                    console.log('teste');
                    $('#divMessage').attr('hidden', false)
                } else {
                    window.location.replace('/edit_ticket?id=' + form.target[0].value)
                }
            }
        })
    })
})