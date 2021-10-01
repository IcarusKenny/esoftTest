<?php 
    require_once('libs/rb-mysql.php');

    session_start();
    
    if (isset($_SESSION['user'])){
        header("location: tasks.php");
    }

    R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');
    $users = R::findAll('user');
    R::close();
?>

<html>
    <header>
        <title>Регистрация</title>    
        <link rel="stylesheet" href="styles.css?v=1.22">
        <script src="script1.js?v=1.2"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </header>
    <body>
        <div class="sign">
            <form onsubmit="return false;">
                <h2>Регистрация</h2>
                <input type="text" placeholder="Логин" required id="login">
                <input type="text" placeholder="Фамилия" required id="surname">
                <input type="text" placeholder="Имя" required id="forename">
                <input type="text" placeholder="Отчество" required id="patronymic">
                <input type="password" placeholder="Пароль" required id="password">
                Мой руководитель:
                <select id="supervisor">
                <?php 
                    foreach ($users as $user){
                        echo "<option value='$user->id'>$user->surname $user->forename $user->patronymic</option>";
                    }
                ?>
                </select>
                <button onclick="ajaxCreateUser()">Зарегистрироваться</button>
                <p id="test"></p>
                <a href="signin.php">Вернуться на страницу входа</a>
            </form>
        </div>
    </body>
</html>