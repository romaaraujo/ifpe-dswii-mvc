const api_url = 'http://187.87.138.176:9090/';
const app_version = 'v1';

const tabela_bancos = $('.tabela-bancos');


$(document).ready(() => {
    isAuth();
    listarBancos();
});

$.ajaxSetup({
    headers: {
        'Authorization': "Bearer " + localStorage.getItem('token')
    }
});

function isAuth() {
    if (localStorage.getItem('token')) {
        $.ajax({
            method: 'POST',
            url: `${api_url}/${app_version}/autenticado`, success: function (result) {

            }, error: function (result) {
                window.location = './login.html'
            }
        });
    }
}

function listarBancos() {
    atualizarSaldo();
    $('.bancos-load').show();
    tabela_bancos.html('');
    $.ajax({
        method: 'POST',
        url: `${api_url}/${app_version}/listarbancos`, success: function (result) {
            if (Array.isArray(result)) {
                if (result.length) {
                    result.forEach(dado => {
                        tabela_bancos.append(`<tr class="bg-light"><td>${dado.codigo}</td><td>${dado.nome}</td><td><button type="button" class="btn btn-danger" onclick="excluirBanco(${dado.id})" title="Excluir">Excluir</button></td></tr>`);
                    });
                }
            }
            $('.bancos-load').hide(1000);
        }, error: function (result) {
            alert(result.erro);
        }
    });
}

function adicionarBanco(elemento_botao) {
    if (!$('.novo-banco-cod').val().length || !$('.novo-banco-nome').val().length) {
        alert('Preencha os campos para a adição do banco.');
        return;
    }

    elemento_botao.attr('disabled', true);

    $.ajax({
        method: 'POST',
        data: { codigo: $('.novo-banco-cod').val(), nome: $('.novo-banco-nome').val() },
        url: `${api_url}/${app_version}/adicionarbanco`, success: function (result) {
            if (result.sucesso !== undefined) {
                alert(result.sucesso);
            }
            listarBancos();
            $('#modalAdicionarBanco').modal('hide');
            elemento_botao.attr('disabled', false);
        }, error: function (result) {
            alert(result.responseJSON.erro);
            elemento_botao.attr('disabled', false);
        }
    });
}

function excluirBanco(id_banco) {
    $('.bancos-load').show();
    $.ajax({
        method: 'POST',
        data: { id_banco: id_banco },
        url: `${api_url}/${app_version}/excluirbanco`, success: function (result) {
            if (result.sucesso !== undefined) {
                alert(result.sucesso);
                listarBancos();
            }
            $('.bancos-load').hide(1000);
        }, error: function (result) {
            $('.bancos-load').hide(1000);
        }
    });
}

function atualizarSaldo() {
    $.ajax({
        method: 'POST',
        url: `${api_url}/${app_version}/saldo`, success: function (result) {
            if (result.saldo !== undefined) {
                $('.saldo').text(((parseFloat(result.saldo)).toLocaleString('pt-BR', { style: 'currency', 'currency': 'BRL' })));
            }
        }
    });
}

function sair()
{
    localStorage.setItem('token', 'null');
    window.location = ('./login.html');
}