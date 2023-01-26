$(document).ready(() => {
    $("form").submit(e => {
        e.preventDefault(e);
        userData = {
            user: e.target[0].value,
            pass: e.target[1].value
        }
        $.ajax({
            type: 'post',
            url: '/authenticate',
            data: userData,
            error: er => {
                console.log('er')
            },
            success: dd => {
                if (dd == 'true') {
                    window.location.replace('/panel')
                }
                console.log(dd)
            }

        })
    })
})
