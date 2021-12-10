<?php

require_once('./../config.php');
// print_r($_GET['token']);
// if (isset($_GET['token'])) {
//     // $_COOKIE['token'] = $_GET['token'];
//     // setcookie('token', $_GET['token']);
//     // header('Location: ./autenticado.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form method="POST" action="<?= API ?>/login">
        <input type="email" name="email" placeholder="E-mail">
        <input type="password" name="senha" placeholder="Senha">
        <input type="submit" value="Entrar">
    </form>
</body>
<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.get('token') != null) {

        localStorage.setItem('token', urlParams.get('token'));

        window.location = ('./autenticado.php');
    }
</script>

</html>