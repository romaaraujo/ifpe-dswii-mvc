<?php

require_once('./../config.php');

if (!isset($_COOKIE['token'])) {
    // header('Location: ./login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticado</title>
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
    <a href="?adicionarTurma">Adicionar Turma</a>
    <?php
    if (isset($_GET['adicionarTurma'])) {
    ?>
        <form action="<?= API ?>adicionarTurma" method="POST">
            <input type="text" placeholder="Título" name="titulo" required>
            <input type="text" placeholder="Sala" name="sala" required>
            <input type="submit" value="Adicionar">
        </form>
    <?php
    } else if (isset($_GET['editarTurma'])) {
    ?>
        <form action="<?= API ?>editarTurma" method="POST">
            <input type="text" name="id" value="<?= $_GET['id'] ?>" />
            <input type="text" placeholder="Título" name="titulo" required />
            <input type="text" placeholder="Sala" name="sala" required />
            <input type="submit" value="Editar">
        </form>
    <?php
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Turma</th>
                <th>Sala</th>
                <th>Criada Em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody class="listaTurmas"></tbody>
    </table>
    <h1>Lista de Alunos</h1>
    <a href="?adicionarAluno">Adicionar Aluno</a>
    <?php
    if (isset($_GET['adicionarAluno'])) {
    ?>
        <form action="<?= API ?>adicionarAluno" method="POST">
            <input type="text" placeholder="Nome" name="nome" required>
            <input type="number" placeholder="Idade" name="idade" required>
            <input type="datetime-local" placeholder="Data de Nascimento" name="dt_nascimento" required>
            <input type="submit" value="Adicionar">
        </form>
    <?php
    } else if (isset($_GET['editarAluno'])) {
    ?>
        <form action="<?= API ?>editarAluno" method="POST">
            <input type="text" name="id" value="<?= $_GET['id'] ?>" />
            <input type="text" placeholder="Nome" name="nome" required />
            <input type="number" placeholder="Idade" name="idade" required />
            <input type="datetime-local" placeholder="Data de Nascimento" name="dt_nascimento" required>
            <input type="submit" value="Editar">
        </form>
    <?php
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Data Nascimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody class="listaAlunos"></tbody>
    </table>
    <h1>Lista de Professores</h1>
    <a href="?adicionarProfessor">Adicionar Professor</a>
    <?php
    if (isset($_GET['adicionarProfessor'])) {
    ?>
        <form action="<?= API ?>adicionarProfessor" method="POST">
            <input type="text" placeholder="Nome" name="nome" required>
            <input type="text" placeholder="Titulação" name="titulacao" required>
            <input type="submit" value="Adicionar">
        </form>
    <?php
    } else if (isset($_GET['editarProfessor'])) {
    ?>
        <form action="<?= API ?>editarProfessor" method="POST">
            <input type="text" name="id" value="<?= $_GET['id'] ?>" />
            <input type="text" placeholder="Nome" name="nome" required />
            <input type="text" placeholder="Titulação" name="titulacao" required />
            <input type="submit" value="Editar">
        </form>
    <?php
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Titulação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody class="listaProfessores"></tbody>
    </table>
    <h1>Lista de Disciplinas</h1>
    <a href="?adicionarDisciplina">Adicionar Disciplina</a>
    <?php
    if (isset($_GET['adicionarDisciplina'])) {
    ?>
        <form action="<?= API ?>adicionarDisciplina" method="POST">
            <input type="text" placeholder="Título" name="titulo" required>
            <input type="submit" value="Adicionar">
        </form>
        <?php
    } else if (isset($_GET['editarDisciplina'])) {
    ?>
        <form action="<?= API ?>editarDisciplina" method="POST">
            <input type="text" name="id" value="<?= $_GET['id'] ?>" />
            <input type="text" placeholder="Título" name="titulo" required />
            <input type="submit" value="Editar">
        </form>
    <?php
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody class="listaDisciplinas"></tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const token = localStorage.getItem('token');

        $(document).ready(() => {
            listarAlunos();
            listarProfessores();
            listarTurmas();
            listarDisciplinas();
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
                            $('.listaAlunos').append(`<tr><td>${dado.id}</td><td>${dado.nome}</td><td>${dado.idade}</td><td>${dado.dt_nascimento}</td><td><a href="<?= API ?>excluirAluno/${dado.id}/${token}">Excluir</a> - <a href="?editarAluno&id=${dado.id}">Editar</a></td></tr>`);
                        });
                    }
                }
            });
        }

        function listarProfessores() {
            $.ajax({
                method: 'POST',
                url: "<?= API ?>professores",
                context: document.body
            }).done(function(data) {
                if (Array.isArray(data)) {
                    if (data.length) {
                        data.forEach(dado => {
                            $('.listaProfessores').append(`<tr><td>${dado.id}</td><td>${dado.nome}</td><td>${dado.titulacao}</td><td><a href="<?= API ?>excluirProfessor/${dado.id}/${token}">Excluir</a> - <a href="?editarProfessor&id=${dado.id}">Editar</a></td></tr>`);
                        });
                    }
                }
            });
        }

        function listarTurmas() {
            $.ajax({
                method: 'POST',
                url: "<?= API ?>turmas",
                context: document.body
            }).done(function(data) {
                if (Array.isArray(data)) {
                    if (data.length) {
                        data.forEach(dado => {
                            $('.listaTurmas').append(`<tr><td>${dado.id}</td><td>${dado.titulo}</td><td>${dado.sala}</td><td>${dado.created_at}</td><td><a href="<?= API ?>excluirTurma/${dado.id}/${token}">Excluir</a> - <a href="?editarTurma&id=${dado.id}">Editar</a> </td></tr>`);
                        });
                    }
                }
            });
        }

        function listarDisciplinas() {
            $.ajax({
                method: 'POST',
                url: "<?= API ?>disciplinas",
                context: document.body
            }).done(function(data) {
                if (Array.isArray(data)) {
                    if (data.length) {
                        data.forEach(dado => {
                            $('.listaDisciplinas').append(`<tr><td>${dado.id}</td><td>${dado.titulo}</td><td><a href="<?= API ?>excluirDisciplina/${dado.id}/${token}">Excluir</a> - <a href="?editarDisciplina&id=${dado.id}">Editar</a></td></tr>`);
                        });
                    }
                }
            });
        }
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        if (localStorage.getItem('token') == null) {

            window.location = ('./login.php');
        }
    </script>
</body>

</html>