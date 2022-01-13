const api_url = 'http://187.87.138.176:9090/';
const app_version = 'v1';

function login(button_element) {
    if (!$('.email').val() || !$('.password').val()) {
        alert('Preencha e-mail e senha');
        return;
    }

    button_element.prop('disabled', true);
    
    $.ajax({
        method: 'POST',
        data: { email: $('.email').val(), password: $('.password').val() },
        headers: {
            'Content-Type':'application/x-www-form-urlencoded'
        },
        url: `${api_url}/login`, success: function (result) {
            if(result.token !== undefined) {
                localStorage.setItem('token', result.token);
                window.location = './historico.html';
            }
            button_element.prop('disabled', false);
        }, error: function (result) {
            alert('E-mail ou senha incorretos.');
            button_element.prop('disabled', false);
        }
    });
}