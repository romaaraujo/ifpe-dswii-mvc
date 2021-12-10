<?php require_once('./../config.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disciplinas</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Lista de Disciplinas</h1>
    <table>
        <thead>
            <tr>
                <th>Titulo</th>
            </tr>
        </thead>
        <tbody class="listaDisciplinas"></tbody>
    </table>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(() => {
        listarDisciplinas();
    })

    function listarDisciplinas() {
        $.ajax({
            method: 'POST',
            url: "<?= API ?>disciplinas",
            context: document.body
        }).done(function(data) {
            if (Array.isArray(data)) {
                if (data.length) {
                    data.forEach(dado => {
                        $('.listaDisciplinas').append(`<tr><td>${dado.titulo}</td></tr>`);
                    });
                }
            }
        });
    }
</script>

</html>