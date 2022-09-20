<?php
require "DBController.php";
class ProjectManagement {
    function getProjectTaskByStatus($statusId, $projectName) {
        $db_handle = new DBController();
        $query = "SELECT * FROM tbl_task WHERE status_id= ? AND project_name = ?";
        $result = $db_handle->runQuery($query, 'is', array($statusId, $projectName));
        return $result;
    }
    
    function getAllStatus() {
        $db_handle = new DBController();
        $query = "SELECT * FROM tbl_status";
        $result = $db_handle->runBaseQuery($query);
        return $result;
    }
    
    function editTaskStatus($status_id, $task_id) {
        $db_handle = new DBController();
        $query = "UPDATE tbl_task SET status_id = ? WHERE id = ?";
        $result = $db_handle->update($query, 'ii', array($status_id, $task_id));
        return $result;
    }

    function add_new_task($title, $description){
    
        $db_handle = new DBController();
        $query = "INSERT INTO tbl_task (title, description, project_name, status_id) values ('$title', '$description','StartTuts', '1')";
        $result = $db_handle->insert_task($query,$title, $description);
        return $result;
    }
    function update_project_name($projectName){
        $db_handle = new DBController();
        $query = "UPDATE tbl_task SET project_name = '$projectName' WHERE status_id = 5";
        $result = $db_handle->update_task($query);
    }
}
?>