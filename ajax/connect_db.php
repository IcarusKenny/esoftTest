<?php
    require_once('libs/rb-mysql.php');
    R::setup( 'mysql:host=yvu4xahse0smimsc.chr7pe7iynqr.eu-west-1.rds.amazonaws.com	;dbname=k9zsbj71aksi2up5','ixc1my3frytj29kr', 'zc6mpj1c9fzvgzca');

    $password = 1;
    $login = 1;
    $password_hash = hash("sha512", $password);

    //R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');
    $user = R::find( 'user', 'login=?', array($login));

    if (!$user){
        $user = R::dispense('user');
        $user->forename = "Дмитрий";
        $user->surname = "Строич";
        $user->patronymic = "Олегович";
        $user->login = $login;
        $user->password = $password_hash;
        $user->supervisor = 0;
        R::store( $user );
        R::close();
    }
?>