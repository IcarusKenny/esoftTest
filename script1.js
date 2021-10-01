function ajaxCreateUser(){
     var forename = $("#forename").val();
     var surname = $("#surname").val();
     var patronymic = $("#patronymic").val();
     var login = $("#login").val();
     var password = $("#password").val();
     var supervisor = $("#supervisor").val();

     $.post("ajax/newUser.php", {
          forename: forename,
          surname: surname,
          patronymic: patronymic,
          login: login,
          password: password,
          supervisor: supervisor
     }, function(data, status){
          $("#test").html(data);
     })
     return false;
};

function ajaxSession(){
     var login = $("#login").val();
     var password = $("#password").val();

     $.post("ajax/startSession.php", {
          login: login,
          password: password
     }, function(data, status){
          if(data=="redirect")
               window.location = "tasks.php";
          else
               $("#test").html(data); 
     })
     return false;
};

function newTask(){
     var name = $("#name").val();
     var description = $("#description").val();
     var startDate = $("#startDate").val();
     var endDate = $("#endDate").val();
     var priority = $("#priority").val();
     var status = $("#status").val();
     var executor = $("#executor").val();

     $.post("ajax/newTask.php", {
          name: name,
          description: description,
          startDate: startDate,
          endDate: endDate,
          priority: priority,
          status: status,
          executor: executor
     }, function(data, status){
          $("#taskStatus").html(data); 
     })
     return false;
};

function changeTask(){
     var name = $("#ch_name").val();
     var description = $("#ch_description").val();
     var startDate = $("#ch_startDate").val();
     var endDate = $("#ch_endDate").val();
     var priority = $("#ch_priority").val();
     var status = $("#ch_status").val();
     var executor = $("#ch_executor").val();
     var id = $("#ch_id").val();

     $.post("ajax/changeTask.php", {
          id: id,
          name: name,
          description: description,
          startDate: startDate,
          endDate: endDate,
          priority: priority,
          status: status,
          executor: executor
     }, function(data, status){
          $("#ch_taskStatus").html(data); 
     })
     return false;
};

function myFunction() {
     if($('input[type=radio][name=tab_name]:checked').val() == "date"){
          var filter = $('input[type=radio][name=sub_name]:checked').val();
          $('.sub').css('display', 'block');
     }
     else {
          var filter = $('input[type=radio][name=tab_name]:checked').val();
          $('.sub').css('display', 'none');
     }

     $.post("ajax/table.php", {
          filter: filter
     }, function(data){
          $("#newTab").html(data); 
     })
     return false;
}


$(document).ready(function(){
     $('#createTask').click(function(){
          $('#newModal').css('display', 'block');
          $("#taskStatus").empty();
     });

     $('.close').click(function(){
          $('.modalBg').css('display', 'none');
     });


     //отсюда

     myFunction();

     $('input[type=radio][name=tab_name]').on('change', function() {
          if($(this).val() == "date"){
               var filter = $('input[type=radio][name=sub_name]:checked').val();
               $('.sub').css('display', 'block');
          }
          else {
               var filter = $(this).val();
               $('.sub').css('display', 'none');
          }
     
          $.post("ajax/table.php", {
               filter: filter
          }, function(data){
               $("#newTab").html(data); 
          })
          return false;
     });

     $('input[type=radio][name=sub_name]').on('change', function() {
          var filter = $(this).val();

          $.post("ajax/table.php", {
               filter: filter
          }, function(data){
               $("#newTab").html(data); 
          })
          return false;
     });
});

$( function() {
     $( ".datepicker" ).datepicker({dateFormat: 'dd.mm.yy'});
} );