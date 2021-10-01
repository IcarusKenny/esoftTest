<?php 
    session_start();
    
    if (isset($_SESSION['user'])){
        header("location: tasks.php");
    }
?>

<html>
    <header>
        <title>Авторизация</title>
        <link rel="stylesheet" href="styles.css?v=1.1111">
        <script src="script1.js?v=1"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </header>
    <body>
        <div class="sign">
            <form onsubmit="return false;">
                <h2>Вход</h2>
                <input type="text" placeholder="Логин" required id="login">
                <input type="password" placeholder="Пароль" required id="password">
                <input type="submit" onclick="ajaxSession()" value="Войти">
                <p id="test"></p>
                <a href="signup.php">Регистрация нового пользователя</a>
            </form>
        </div>
    </body>
</html>


