<?php
require './config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // For Creating New Task
    if (isset($_POST['createTask'])) {
        $taskDesc = trim($_POST['taskdesc']);
        try {
            $sql = "INSERT INTO tasks (task) VALUES (:task)";
            $stml = $conn->prepare($sql);
            $stml->execute([':task' => $taskDesc]);
            $_SESSION['msg'] = "Task Created Successfully";
            header("Location: ./");
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error : " . $e->getMessage();
            header("Location: ./");
            exit;
        }
    }

    // For Deleting the Task
    if (isset($_POST['deleteTask'])) {
        $taskId = $_POST['taskId'];
        try {
            $sql = "DELETE FROM tasks where id = :id";
            $stml = $conn->prepare($sql);
            $stml->execute([
                ':id' => $taskId
            ]);
            $_SESSION['msg'] = "Task Is Deleted Successfully!";
            header("Location: ./");
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error : " . $e->getMessage();
            header("Location: ./");
            exit;
        }
    }

    // For Updating the Task
    if (isset($_POST['updateTask'])) {
        $taskId = $_POST['taskId'];
        $task = trim($_POST['taskText']);
        try{
            $sql = "UPDATE tasks SET task = :task where id = :id";
            $stml = $conn->prepare($sql);
            $stml->execute([
                ':task' => $task,
                ':id' => $taskId
            ]);
            $_SESSION['msg'] = "Task Updated Successfully!";
            header("Location: ./");
            exit;
        }
        catch(PDOException $e){
            $_SESSION['error'] = "Error : " . $e->getMessage();
            header("Location: ./");
            exit;
        }
    }

    // For Completing the Task
    if(isset($_POST['completeTask'])){
        $taskId = $_POST['taskId'];
        try{
            $sql = "UPDATE tasks set done = 1 where id = :id";
            $stml = $conn->prepare($sql);
            $stml->execute([
                ':id' => $taskId
            ]);
            header("Location: ./");
            exit;
        }
        catch(PDOException $e){
            $_SESSION['error'] = "Error : " . $e->getMessage();
            header("Location: ./");
            exit;
        }
    }

    // For UnCompleting the Task
    if(isset($_POST['unCompleteTask'])){
        $taskId = $_POST['taskId'];
        try{
            $sql = "UPDATE tasks set done = 0 where id = :id";
            $stml = $conn->prepare($sql);
            $stml->execute([
                ':id' => $taskId
            ]);
            header("Location: ./");
            exit;
        }
        catch(PDOException $e){
            $_SESSION['error'] = "Error : " . $e->getMessage();
            header("Location: ./");
            exit;
        }
    }

} else {
    echo "Access Denied";
}
