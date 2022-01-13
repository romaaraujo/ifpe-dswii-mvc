const api_url = 'http://187.87.138.176:9090/';
const app_version = 'v1';

const tabela_historico = $('.tabela-historico');


$(document).ready(() => {
    isAuth();
    listarHistorico();
    listarBancos();
    listarFormasPagamento();
});

$.ajaxSetup({
    crossDomain: true,
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
                // window.location = './login.html'
            }
        });
    }
}

function listarHistorico() {
    atualizarSaldo();
    $('.historico-load').show();
    tabela_historico.html('');
    $.ajax({
        method: 'POST',
        url: `${api_url}/${app_version}/listarhistorico`, success: function (result) {
            if (Array.isArray(result)) {
                if (result.length) {
                    result.forEach(dado => {
                        tabela_historico.append(`<tr class="bg-light">
                        <td>
                        ${dado.tipo}</td><td>${(parseFloat(dado.valor)).toLocaleString('pt-BR', { style: 'currency', 'currency': 'BRL' })}</td>
                        <td>${dado.nome}</td>
                        <td>${dado.nome_banco}</td>
                        <td>${dado.created_at}</td>
                        <td>
                        <button class="btn btn-success" data-toggle="modal" onclick="$('.btn-editar-conta').attr('id', ${dado.id_conta});$('.editar-conta-banco').val('${dado.nome_banco}');$('.editar-conta-forma-pagamento').val('${dado.nome}');$('.editar-conta-valor').val('${dado.valor}');$('.editar-conta-tipo').val('${dado.tipo}');" data-target="#modalEditarConta">Editar</button>
                        <button type="button" class="mr-1 btn btn-danger" onclick="excluirConta(${dado.id_conta})" title="Excluir">Excluir</button>
                        </td></tr>`);
                    });
                }
            }
            $('.historico-load').hide(1000);
        }, error: function (result) {
            alert(result.erro);
        }
    });
}

function listarBancos() {
    const bancos = $('.nova-conta-banco');
    $.ajax({
        method: 'POST',
        url: `${api_url}/${app_version}/listarbancos`, success: function (result) {
            if (Array.isArray(result)) {
                if (result.length) {
                    result.forEach(dado => {
                        bancos.append(`<option value="${dado.id}">${dado.nome}</option>`);
                    });
                }
            }
        }, error: function (result) {
            alert(result.erro);
        }
    });
}

function listarFormasPagamento() {
    const formas_pagamento = $('.nova-conta-forma-pagamento');
    $.ajax({
        method: 'POST',
        url: `${api_url}/${app_version}/listarformaspagamento`, success: function (result) {
            if (Array.isArray(result)) {
                if (result.length) {
                    result.forEach(dado => {
                        formas_pagamento.append(`<option value="${dado.id}">${dado.nome}</option>`);
                    });
                }
            }
        }, error: function (result) {
            alert(result.erro);
        }
    });
}

function adicionarConta(elemento_botao) {
    if (!$('.nova-conta-forma-pagamento').val().length || !$('.nova-conta-banco').val().length || !$('.nova-conta-valor').val().length || !$('.nova-conta-tipo').val().length) {
        alert('Preencha os campos para a adição da movimentação.');
        return;
    }

    elemento_botao.attr('disabled', true);

    $.ajax({
        method: 'POST',
        data: { banco: $('.nova-conta-banco').val(), forma_pagamento: $('.nova-conta-forma-pagamento').val(), valor: $('.nova-conta-valor').val(), tipo: $('.nova-conta-tipo').val() },
        url: `${api_url}/${app_version}/adicionarconta`, success: function (result) {
            if (result.sucesso !== undefined) {
                alert(result.sucesso);
            }
            listarHistorico();
            $('#modalAdicionarConta').modal('hide');
            elemento_botao.attr('disabled', false);
        }, error: function (result) {
            alert(result.responseJSON.erro);
            elemento_botao.attr('disabled', false);
        }
    });
}

function excluirConta(id_conta) {
    $('.historico-load').show();
    $.ajax({
        method: 'POST',
        data: { id_conta: id_conta },
        url: `${api_url}/${app_version}/excluirconta`, success: function (result) {
            if (result.sucesso !== undefined) {
                alert(result.sucesso);
                listarHistorico();
            }
            $('.historico-load').hide(1000);
        }, error: function (result) {
            $('.historico-load').hide(1000);
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

function editarConta(elemento_botao) {
    if (!$('.editar-conta-forma-pagamento').val().length || !$('.editar-conta-banco').val().length || !$('.editar-conta-valor').val().length || !$('.editar-conta-tipo').val().length) {
        alert('Preencha os campos para a adição da movimentação.');
        return;
    }

    if (!elemento_botao.attr('id')) {
        return;
    }

    elemento_botao.attr('disabled', true);

    $.ajax({
        method: 'POST',
        data: { id_conta: elemento_botao.attr('id'), banco: $('.editar-conta-banco').val(), forma_pagamento: $('.editar-conta-forma-pagamento').val(), valor: $('.editar-conta-valor').val(), tipo: $('.editar-conta-tipo').val() },
        url: `${api_url}/${app_version}/editarconta`, success: function (result) {
            if (result.sucesso !== undefined) {
                alert(result.sucesso);
            }
            listarHistorico();
            $('#modalEditarConta').modal('hide');
            elemento_botao.attr('disabled', false);
        }, error: function (result) {
            alert(result.responseJSON.erro);
            elemento_botao.attr('disabled', false);
        }
    });
}

function sair() {
    localStorage.setItem('token', 'null');
    window.location = ('./login.html');
}