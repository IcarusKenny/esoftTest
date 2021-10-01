<?php
    //require_once('libs/rb-mysql.php');
    
    session_start();
    if(!isset($_SESSION['user'])) 
        header("location: signin.php");

    $me = $_SESSION['user'];

    require('connect_db.php');
    //R::setup( 'mysql:host=localhost;dbname=test_esoft','root', '');
    $me_rec = R::findOne('user', ' WHERE id = ? ', array($me));
    $users = R::findAll('user', ' WHERE supervisor = ? or id = ?', array($me, $me));
    R::close();
?>

<html>
    <header>
        <title>Мои задачи</title>
        <link rel="stylesheet" href="styles.css?v1.1323111111">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </header>
    <body>
        <p class="me">Вы вошли как <br><?="$me_rec->surname $me_rec->forename $me_rec->patronymic"?><br>
        <a href="logout.php" class="logout">Выйти</a></p>
        <button id="createTask">Создать задачу</button>

        <div id="newModal" class="modalBg">
            <div class="modal">
                <span class="close x">✖</span>
                <form id="addTask" onsubmit="return false;" autocomplete="off">
                    <h2>Новая задача</h2>
                    <p>Название:</p>
                    <input type='text' placeholder='Название' required id="name">
                    <p>Описание задачи:</p>
                    <textarea required id="description" cols="30" rows="7"></textarea>
                    <p>Начало выполнения:</p>
                    <input type='text' placeholder='Начало выполнения' required id="startDate" class="datepicker">
                    <p>Выполнить до:</p>
                    <input type='text' placeholder='Выполнить до' required id="endDate" class="datepicker">
                    <p>Приоритет:</p>
                    <select required id="priority">
                        <option value="Низкий">Низкий</option>
                        <option value="Средний">Средний</option>
                        <option value="Высокий">Высокий</option>
                    </select>
                    <p>Состояние:</p>
                    <select required id="status">
                        <option value="К выполнению">К выполнению</option>
                        <option value="Выполняется">Выполняется</option>
                        <option value="Выполнена">Выполнена</option>
                        <option value="Отменена">Отменена</option>
                    </select>
                    <p>Исполнитель:</p>
                    <select required id="executor">
                        <?php 
                            foreach ($users as $user){
                                echo "<option value='$user->id'>$user->surname $user->forename $user->patronymic</option>";
                            }
                        ?>
                    </select>
                    <p id="taskStatus"></p>
                    <button onclick="newTask()">Создать задачу</button>
                    <button class="close">Отменить</button>
                </form>
            </div>
        </div>


        <div id="changeModal" class="modalBg">
            <div class="modal">
                <span class="close x">✖</span>
                <form onsubmit="return false;" autocomplete="off">
                    <h2>Изменить задачу</h2>
                    <p>Название:</p>
                    <input type='text' placeholder='Название' required id="ch_name">
                    <p>Описание задачи:</p>
                    <textarea required id="ch_description" cols="30" rows="7"></textarea>
                    <p>Начало выполнения:</p>
                    <input type='text' placeholder='Начало выполнения' required id="ch_startDate" class="datepicker">
                    <p>Выполнить до:</p>
                    <input type='text' placeholder='Выполнить до' required id="ch_endDate" class="datepicker">
                    <p>Приоритет:</p>
                    <select required id="ch_priority">
                        <option value="Низкий">Низкий</option>
                        <option value="Средний">Средний</option>
                        <option value="Высокий">Высокий</option>
                    </select>
                    <p>Состояние:</p>
                    <select required id="ch_status">
                        <option value="К выполнению">К выполнению</option>
                        <option value="Выполняется">Выполняется</option>
                        <option value="Выполнена">Выполнена</option>
                        <option value="Отменена">Отменена</option>
                    </select>
                    <input type="hidden" id="ch_id">
                    <p>Исполнитель:</p>
                    <select required id="ch_executor">
                        <?php 
                            foreach ($users as $user){
                                echo "<option value='$user->id'>$user->surname $user->forename $user->patronymic</option>";
                            }
                        ?>
                    </select>
                    <p id="ch_taskStatus"></p>
                    <button onclick="changeTask()">Изменить задачу</button>
                    <button class="close">Отменить</button>
                </form>
            </div>
        </div>

        <div class="tab_names">
            <input type="radio" id="tab_name1" name="tab_name" class="tab_radio" value="date" checked>
            <label for="tab_name1" class="tab_name">По дате завершения</label>
            <input type="radio" id="tab_name2" name="tab_name" class="tab_radio" value="executor">
            <label for="tab_name2" class="tab_name">По ответственным (режим просмотра руководителя)</label>
            <input type="radio" id="tab_name3" name="tab_name" class="tab_radio" value="update">
            <label for="tab_name3" class="tab_name">По дате последнего обновления</label>
        </div>

        <div class="sub">
            <div>
                <input type="radio" id="sub_name1" name="sub_name" class="sub_radio" value="today" checked>
                <label for="sub_name1" class="sub_name">Задачи на сегодня</label>
                <input type="radio" id="sub_name2" name="sub_name" class="sub_radio" value="week">
                <label for="sub_name2" class="sub_name">Задачи на неделю</label>
                <input type="radio" id="sub_name3" name="sub_name" class="sub_radio" value="future">
                <label for="sub_name3" class="sub_name">Задачи на будущее</label>
            </div>
        </div>

        <div class="tab" id="newTab"></div>

        <script src="script1.js?v=1.21"></script>
    </body>
</html>