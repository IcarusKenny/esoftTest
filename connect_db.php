<?php
    require_once('libs/rb-mysql.php');
    //R::setup( 'mysql:host=yvu4xahse0smimsc.chr7pe7iynqr.eu-west-1.rds.amazonaws.com; dbname=k9zsbj71aksi2up5','ixc1my3frytj29kr', 'zc6mpj1c9fzvgzca');

    R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');

    $listOfTables = R::inspect();

    if(!in_array('task',$listOfTables)){
        $task = 'CREATE TABLE task (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name char(255),
            description text,
            priority char(255),
            status char(255),
            author INT(11),
            executor INT(11),
            start_date date,
            end_date date,
            update_date	datetime
        )';

        R::exec($task);
    }
    if(!in_array('user',$listOfTables)){
        $user = 'CREATE TABLE user (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            forename char(255),
            surname char(255),
            patronymic char(255),
            login char(255),
            password char(255),
            supervisor INT(11)
        )';

        R::exec($user);
    }
    if(count(R::getAll( 'SELECT * FROM user' )) == 0){
        $password = "1";
        $password_hash = hash("sha512", $password);

        $user = R::dispense('user');
        $user->forename = "Дмитрий";
        $user->surname = "Строич";
        $user->patronymic = "Олегович";
        $user->login = "1";
        $user->password = $password_hash;
        $user->supervisor = 0;
        R::store( $user );
    }
?>