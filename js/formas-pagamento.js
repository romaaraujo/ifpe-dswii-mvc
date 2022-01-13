const api_url = 'http://187.87.138.176:9090/';
const app_version = 'v1';

const tabela_formas_pagamento = $('.tabela-formas-pagamento');


$(document).ready(() => {
    isAuth();
    listarFormasPagamento();
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

function listarFormasPagamento() {
    atualizarSaldo();
    $('.formas-pagamento-load').show();
    tabela_formas_pagamento.html('');
    $.ajax({
        method: 'POST',
        url: `${api_url}/${app_version}/listarformaspagamento`, success: function (result) {
            if (Array.isArray(result)) {
                if (result.length) {
                    result.forEach(dado => {
                        tabela_formas_pagamento.append(`<tr class="bg-light"><td>${dado.nome}</td><td><button type="button" class="btn btn-danger" onclick="excluirFormaPagamento(${dado.id})" title="Excluir">Excluir</button></td></tr>`);
                    });
                }
            }
            $('.formas-pagamento-load').hide(1000);
        }, error: function (result) {
            alert(result.erro);
        }
    });
}

function adicionarFormaPagamento(elemento_botao) {
    if (!$('.nova-forma-pagamento-nome').val().length ) {
        alert('Preencha os campos para a adição da forma de pagamento.');
        return;
    }

    elemento_botao.attr('disabled', true);

    $.ajax({
        method: 'POST',
        data: { nome: $('.nova-forma-pagamento-nome').val() },
        url: `${api_url}/${app_version}/adicionarformapagamento`, success: function (result) {
            if (result.sucesso !== undefined) {
                alert(result.sucesso);
            }
            listarFormasPagamento();
            $('#modalAdicionarFormaPagamento').modal('hide');
            elemento_botao.attr('disabled', false);
        }, error: function (result) {
            alert(result.responseJSON.erro);
            elemento_botao.attr('disabled', false);
        }
    });
}

function excluirFormaPagamento(id_forma_pagamento) {
    $('.formas-pagamento-load').show();
    $.ajax({
        method: 'POST',
        data: {id_forma_pagamento: id_forma_pagamento},
        url: `${api_url}/${app_version}/excluirformapagamento`, success: function (result) {
            if (result.sucesso !== undefined) {
                alert(result.sucesso);
                listarFormasPagamento();                
            }
            $('.formas-pagamento-load').hide(1000);
        }, error: function (result) {
            $('.formas-pagamento-load').hide(1000);
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