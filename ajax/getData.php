<?php
    //require_once('libs/rb-mysql.php');
    require('connect_db.php');

    session_start();

    $me = $_SESSION['user'];

    //R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');
    $task = R::findOne('task', ' WHERE id = ?', array($_POST['id']));
    R::close();

    $i_am_author = false;

    if($me == $task->author)
        $i_am_author = true;

    $array = array(
        $task->name,
        $task->description,
        date("d.m.Y", strtotime($task->start_date)),
        date("d.m.Y", strtotime($task->end_date)),
        $task->priority,
        $task->status,
        $task->executor,
        $task->id,
        $i_am_author    
    );
    echo json_encode($array);
?>