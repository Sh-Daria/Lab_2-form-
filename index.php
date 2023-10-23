<?php

require_once 'User.php';
require_once 'FileUserPersist.php';
require_once 'DatabaseUserPersist.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $filePersister = new DatabaseUserPersist();

    if (isset($_GET['action']) && 'login' === $_GET['action']) {
        $user = $filePersister->get(strtolower($_POST['login']));
        if (!$user) {
            die('Некорректный логин или пароль');
        }

        if ($user->getPassword() === sha1($_POST['password'])) {
            session_start();

            $_SESSION['user'] = $user->getLogin();
        }

        header('Location: index.php');
        die();
    }

    $user = new User((string) $_POST['login'], (string) $_POST['password'], (string) $_POST['password2']);

    echo $user->getCreatedAt()->format('d.m.Y H:i:s') . '<br>';
    echo ($user->isPasswordsEquals() ? 'Одинаковые' : 'Разные') . ' пароли';

    if (!$user->isPasswordsEquals()) {
        echo 'Ошибка: пароли не одинаковые';
        die();
    }

    if ($filePersister->get($_POST['login']) instanceof User) {
        echo 'Ошибка: пользователь уже существует';
        die();
    }

    $filePersister->save($user);

    header('Location: index.php?registration=success');
    die();

}

if (isset($_GET['action']) && 'logout' === $_GET['action']) {
    session_unset();
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Заголовок страницы в браузере</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <img src="img/img1.jpg" alt="" width="110" height="57">
            <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Регистрация</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Главная</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Профиль</a></li>
        </ul>
    </header>
</div>
<div class="container">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_SESSION['user'])) {
            echo sprintf('Привет, %s', $_SESSION['user']) . '<a class="btn btn-success" href="index.php?action=logout">Выход</a><br />';
        }
        ?>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="login" class="form-label">Логин</label>
            <input type="text" class="form-control" name="login" id="login">
        </div>

        <div class="mb-3">
            <label for="password-field1" class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password" id="password-field1" placeholder="Пароль">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput2" class="form-label">Подтверждение пароля</label>
            <input type="password" class="form-control" name="password2" id="exampleFormControlInput2" placeholder="Подтверждение пароля">
        </div>

        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Сохранить">
        </div>
    </form>
    <?php
    }
    ?>
</div>
<div class="container">
    <?php

    if (isset($_GET['registration']) && 'success' === $_GET['registration']) {
        ?>
        <form action="index.php?action=login" method="post">
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" name="login" id="login">
            </div>

            <div class="mb-3">
                <label for="password-field1" class="form-label">Пароль</label>
                <input type="password" class="form-control" name="password" id="password-field1" placeholder="Пароль">
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Войти">
            </div>
        </form>
    <?php
    }

    ?>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>