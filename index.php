<?php
require_once "ProjectManagement.php";

$projectName = "StartTuts";
$projectManagement = new ProjectManagement();
$statusResult = $projectManagement->getAllStatus();

function button1($user_insert) {
    $button_project = new ProjectManagement();
    $new_task = $button_project->add_new_task("$user_insert","User Insert");
}

function empty_trashcan(){
    $clean_trashcan = new ProjectManagement();
    $clean_trashcan->update_project_name('Trashcan');
}

?>
<html>

<head>

<title>Trello Local</title>

<link rel="stylesheet"
    href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src = "https://code.jquery.com/jquery-1.12.4.js"></script>

<script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
body {
    font-family: Helvetica;
}
.task-board {
    background: #6746c3;
    display: inline-block;
    padding: 12px;
    border-radius: 3px;
    width: 99%;
    white-space: nowrap;
    overflow-x: scroll;
    min-height: 100%;
}

.status-card {
    width: 250px;
    margin-right: 8px;
    background: #311b92;
    border-radius: 3px;
    display: inline-block;
    vertical-align: top;
    font-size: 1.1em;
}

.status-card:last-child {
    margin-right: 0px;
}

.card-header {
    width: 100%;
    padding: 10px 10px 0px 10px;
    box-sizing: border-box;
    border-radius: 3px;
    display: block;
    font-weight: bold;
}

.card-header-text {
    display: block;
}

ul.sortable {
    padding-bottom: 10px;
}

ul.sortable li:last-child {
    margin-bottom: 0px;
}

ul {
    list-style: none;
    margin: 0;
    padding: 0px;
}

.text-row {
    padding: 15px 10px;
    margin: 10px;
    background: #ffff;
    box-sizing: border-box;
    border-radius: 3px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
    font-size: 1.0em;
    white-space: normal;
    line-height: 20px;
}

.ui-sortable-placeholder {
    visibility: inherit !important;
    background: transparent;
    border: #666 2px dashed;
}
</style>
</head>
<body>

        <div class="task-board">

        <div>

            <form method="post" style="font-size: 1.0em; ">

                enter task content: <input type="text" name="formulario" class= "button" style="width:300px; border-radius: 20px; padding:5px; font-size: 1.1em;" >
                <input type="submit" name="button1" class="button" value="Add a new task" style="width: 150px; border-radius: 20px; margin-top:10px; font-size: 1.1em;">
                <a target="_blank" href="https://github.com/vbsx" style="margin-left: 10%; text-align: center; color:#f5f5f5">See my github for futures projects<img src="images/github.png" ></a> 
                <?php
                    
                    if(array_key_exists('button1', $_POST)) {
                        $user_insert = $_POST["formulario"];
                        if(empty($user_insert)){
                            echo "Cannot be empty!";
                        }
                        else{
                            button1($user_insert);      
                        } 
                    }
                ?>
            </form>

        </div>

            <?php

            foreach ($statusResult as $statusRow) {

                if($statusRow["id"] == 5){
                    empty_trashcan();
                }
                $taskResult = $projectManagement->getProjectTaskByStatus($statusRow["id"], $projectName);
                
                ?>
                <div class="status-card">

                    <div class="card-header">

                        <span class="card-header-text"><?php echo $statusRow["status_name"]; ?></span>

                    </div>

                    <ul class="sortable ui-sortable"

                        id="sort<?php echo $statusRow["id"]; ?>"

                        data-status-id="<?php echo $statusRow["id"]; ?>">

                <?php
                if (! empty($taskResult)) {

                    foreach ($taskResult as $taskRow) {

                        ?>
                
                     <li class="text-row ui-sortable-handle"
                            data-task-id="<?php echo $taskRow["id"]; ?>"><?php echo $taskRow["title"]; ?></li>
                <?php
                    }
                }
                ?>
                                                 </ul>
                </div>
                <?php

            }
            ?>
        </div>
    <script>
 $( function() {

     var url = 'edit-status.php';

     $('ul[id^="sort"]').sortable({

         connectWith: ".sortable",
         receive: function (e, ui) {

             var status_id = $(ui.item).parent(".sortable").data("status-id");

             var task_id = $(ui.item).data("task-id");

             $.ajax({

                 url: url+'?status_id='+status_id+'&task_id='+task_id,

                 success: function(response){
                     }
             });
             }
     
     }).disableSelection();

     } );
  </script>

</body>
</html>