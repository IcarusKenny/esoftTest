<?php 
    //require_once('libs/rb-mysql.php');
    require_once(__DIR__ . '/../connect_db.php');

    session_start();

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $startDate = filter_var($_POST['startDate'], FILTER_SANITIZE_STRING);
    $endDate = filter_var($_POST['endDate'], FILTER_SANITIZE_STRING);
    $priority = $_POST['priority'];
    $id = $_POST['id'];
    $status = $_POST['status'];
    $executor = $_POST['executor'];

    if($id && $name && $description && $startDate && $endDate && $priority && $status && $executor)
    {
        $startDate = explode(".", $startDate);
        $startDate = "$startDate[2]-$startDate[1]-$startDate[0]";
        $endDate = explode(".", $endDate);
        $endDate = "$endDate[2]-$endDate[1]-$endDate[0]";
        $updateDate = date("Y-m-d H:i:s");

        //R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');

        $task = R::findOne('task', ' WHERE id = ?', array($id));

        $task->name = $name;
        $task->description = $description;
        $task->start_date = $startDate;
        $task->end_date = $endDate;
        $task->update_date = $updateDate;
        $task->priority = $priority;
        $task->status = $status;
        $task->executor = $executor;
        R::store( $task );

        R::close();
        
        echo "<span class='success'>Задача обновлена!</span>";
    }
?>