<?php 
    //require_once('libs/rb-mysql.php');
    require('connect_db.php');

    session_start();

    $me = $_SESSION['user'];

    $filter = $_POST['filter'];


    //R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');
    $users = R::findAll('user');

    switch($filter){
        case "today":
            $sortFilter = R::findAll('task', ' WHERE end_date = ? AND (author = ? OR executor = ?) ORDER BY end_date ', array(date("Y-m-d"), $me, $me));
            break;
        case "week":
            $sortFilter = R::findAll('task', ' WHERE end_date BETWEEN ? AND ? AND (author = ? OR executor = ?) ORDER BY end_date ', array(date("Y-m-d"), date("Y-m-d", strtotime('+1 Week')), $me, $me));
            break;
        case "future":
            $sortFilter = R::findAll('task', ' WHERE end_date > ? AND (author = ? OR executor = ?) ORDER BY end_date ', array(date("Y-m-d", strtotime('+1 Week')), $me, $me));
            break;
        case "executor":
            $sortFilter = R::findAll('task', ' WHERE author = ? ORDER BY executor desc ', array($me));
            break;
        case "update":
            $sortFilter = R::findAll('task', ' WHERE author = ? OR executor = ? ORDER BY update_date desc ', array($me, $me));
            break;
    }


    if (count($sortFilter) > 0){
        $table = '<table id="table"><tr><th>Задача</th><th>Приоритет</th><th>Срок</th><th>Ответственный</th><th>Статус</th></tr>';
        $today = date("Y-m-d");

        foreach ($sortFilter as $record){
            $executor = R::findOne('user', 'id = ?', array($record->executor));   
            $table .= "<tr class='record' data-id='$record->id'>";
            if ($record->status === "Выполнена")
                $table .= "<td class='done'>$record->name</td>";
            else if($record->end_date < $today)
                $table .= "<td class='expired'>$record->name</td>";
            else 
                $table .= "<td class='other'>$record->name</td>";
            $date = date("d.m.Y", strtotime($record->end_date));
            $table .= "<td>$record->priority</td><td>$date</td><td>$executor->surname $executor->forename $executor->patronymic</td><td>$record->status</td>";
            $table .= '</tr>';
        }
        $table .= "</table>";

        echo $table;
    }
    else{
        echo "<h2>Задач нет!</h2>";
    }

    R::close();
?>

<script>
    $(document).ready(function() {
        $('#table tr:not(:first-child)').click(function() {
            var id = $(this).attr("data-id");

            $("#ch_taskStatus").empty();

            $.ajax({
                type: 'POST',
                url: 'ajax/getData.php',
                data: {id: id},
                dataType: 'json',
                success: function(result) {
                    $('#changeModal #ch_name').val(result[0]);
                    $('#changeModal #ch_description').val(result[1]);
                    $('#changeModal #ch_startDate').val(result[2]);
                    $('#changeModal #ch_endDate').val(result[3]);
                    $('#changeModal #ch_priority').val(result[4]);
                    $('#changeModal #ch_status').val(result[5]);
                    $('#changeModal #ch_executor').val(result[6]);
                    $('#changeModal #ch_id').val(result[7]);

                    if(result[8]){
                        $('#changeModal #ch_name').attr('disabled', false);
                        $('#changeModal #ch_description').attr('disabled', false);
                        $('#changeModal #ch_startDate').attr('disabled', false);
                        $('#changeModal #ch_endDate').attr('disabled', false);
                        $('#changeModal #ch_priority').attr('disabled', false);
                        $('#changeModal #ch_executor').attr('disabled', false);
                    }
                    else{
                        $('#changeModal #ch_name').attr('disabled', true);
                        $('#changeModal #ch_description').attr('disabled', true);
                        $('#changeModal #ch_startDate').attr('disabled', true);
                        $('#changeModal #ch_endDate').attr('disabled', true);
                        $('#changeModal #ch_priority').attr('disabled', true);
                        $('#changeModal #ch_executor').attr('disabled', true);
                    }
                },
            });

            $('#changeModal').css('display', 'block');
        });
    });
</script>