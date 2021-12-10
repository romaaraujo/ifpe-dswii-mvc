<?php require_once('./../config.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Lista de Alunos</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Data Nascimento</th>
            </tr>
        </thead>
        <tbody class="listaAlunos"></tbody>
    </table>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(() => {
        listarAlunos();
    })

    function listarAlunos() {
        $.ajax({
            method: 'POST',
            url: "<?= API ?>alunos",
            context: document.body
        }).done(function(data) {
            if (Array.isArray(data)) {
                if (data.length) {
                    data.forEach(dado => {
                        $('.listaAlunos').append(`<tr><td>${dado.nome}</td><td>${dado.idade}</td><td>${dado.dt_nascimento}</td></tr>`);
                    });
                }
            }
        });
    }
</script>

</html>