<?php 
    //require_once('libs/rb-mysql.php');
    require_once(__DIR__ . '/../connect_db.php');

    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    
    if($login && $password)
    {
        $password_hash = hash("sha512", $login.$password);

        //R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');
        $user = R::findOne( 'user', 'login=?', array($login));

        if (!$user){
            R::close();
            echo "<span class='error'>Пользователя с таким логином не существует</span>";
        }
        else if($user->password != $password_hash){
            R::close();
            echo "<span class='error'>Неверный пароль!</span>";
        }
        else{
            R::close();
            session_start();
            $_SESSION['user'] = $user->id;
            echo "redirect";
        }
    }
?>