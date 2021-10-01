<?php 
    //require_once('libs/rb-mysql.php');
    require('connect_db.php');

    $forename = filter_var(trim($_POST['forename']), FILTER_SANITIZE_STRING);
    $surname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
    $patronymic = filter_var(trim($_POST['patronymic']), FILTER_SANITIZE_STRING);
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $supervisor = $_POST['supervisor'];

    if($forename && $surname && $patronymic && $login && $password && $supervisor)
    {
        $password_hash = hash("sha512", $login.$password);

        //R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');
        $user = R::find( 'user', 'login=?', array($login));

        if ($user){
            R::close();
            echo "<span class='error'>Пользователь с таким логином уже существует!</span>";
        }
        else {
            $user = R::dispense('user');
            $user->forename = $forename;
            $user->surname = $surname;
            $user->patronymic = $patronymic;
            $user->login = $login;
            $user->password = $password_hash;
            $user->supervisor = $supervisor;
            R::store( $user );
            R::close();
            echo "<span class='success'>Регистрация прошла успешно!</span>";
        }
    }
?>