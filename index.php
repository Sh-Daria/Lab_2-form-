<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
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
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>

        <form action="index.php" method="post">
            <h3 style="text-align: center">Введите следующую информацию: </h3>
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" name="login" id="login">
            </div>

            <div class="mb-3">
                <label for="password-fieldl" class="form-label">Пароль</label>
                <input type="password" class="form-control" name="password" id="password-fieldl">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Подтверждение пароля</label>
                <input type="password" class="form-control" name="password2" id="exampleFormControlInput3" placeholder="Подтвердить пароль">
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Сохранить данные">
                <img src="img/img2.png" style="float: right" width="450" height="290">
            </div>
        </form>
        <?php
    }
    ?>
</div>

<div class="container">
    <?php

    require_once 'User.php';
    require_once 'FileUserPersist.php';
    require_once 'DatabaseUserPersist.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = new User((string) $_POST['login'], (string) $_POST['password'], (string) $_POST['password2']);
        
        echo $user->getCreatedAt()->format(format:'d.m.Y H:i:s') . '<br>';
        echo ($user->isPasswordsEquals() ?'Одинаковые':'Разные') . ' пароли ';

        if (!$user->isPasswordsEquals()) {
            echo 'Ошибка: пароли не одинаковые';
        }

        $filePersister = new FileUserPersist();
        $databasePersister = new databaseUserPersist();

        $filePersister->save($user);
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>