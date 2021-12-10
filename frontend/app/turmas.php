<?php require_once('./../config.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Lista de Turmas</h1>
    <table>
        <thead>
            <tr>
                <th>Turma</th>
                <th>Sala</th>
                <th>Criada Em</th>
            </tr>
        </thead>
        <tbody class="listaTurmas"></tbody>
    </table>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(() => {
        listarTurmas();
    })

    function listarTurmas() {
        $.ajax({
            method: 'POST',
            url: "<?= API ?>turmas",
            context: document.body
        }).done(function(data) {
            if (Array.isArray(data)) {
                if (data.length) {
                    data.forEach(dado => {
                        $('.listaTurmas').append(`<tr><td>${dado.titulo}</td><td>${dado.sala}</td><td>${dado.created_at}</td></tr>`);
                    });
                }
            }
        });
    }
</script>

</html>