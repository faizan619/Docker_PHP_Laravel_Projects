<?php
require './config.php';
session_start();

// Fetch Data From Tasks Table
try {
    $sql = "SELECT * FROM tasks";
    $stml = $conn->prepare($sql);
    $stml->execute();
    $stml->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stml->fetchAll();
} catch (PDOException $e) {
    $_SESSION['error1'] = "Failed to Fetch Data! Error : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap 5 CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- iCheck Bootstrap (for styled checkboxes) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
    <title>Todo App</title>
</head>

<body style="min-height: 100vh;" class="d-flex flex-column">
    <?php include "./navbar.php" ?>
    <div class="container">
        <div class="col-md-8 mx-auto">
            <?php
            if (isset($_SESSION['msg'])) {
                echo '<div class="alert alert-success text-center mt-3">' . htmlspecialchars($_SESSION['msg']) . '</div>';
                unset($_SESSION['msg']);
            }
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger text-center mt-3">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <div class="card mt-3 mx-auto">
                <div class="card-header bg-danger text-light">
                    Todo Application
                </div>
                <div class="card-body">
                    <form action="./handling.php" method="POST">
                        <label for="taskdesc">Task Description <span class="text-danger">*</span></label>
                        <textarea name="taskdesc" id="taskdesc" class="form-control mt-2" required placeholder="Enter Your Task" rows="3"></textarea>
                        <div class="text-center">
                            <input type="submit" name="createTask" class="btn btn-danger mt-2">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header bg-dark text-light">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        To Do List
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="todo-list" data-widget="todo-list">
                        <?php
                        if (!empty($result)) {
                            foreach ($result as $key => $res) {
                                $isDone = $res['done'] ? 'checked' : '';
                                $isDoneCheck = $res['done'];
                                $taskText = htmlspecialchars($res['task']);
                                $createdAt = date('d-m-Y', strtotime($res['created_at']));
                                $taskId = $res['id'];
                        ?>
                                <li>
                                    <!-- drag handle -->
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <!-- checkbox -->
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" disabled value="" name="todo<?= $taskId ?>" id="todoCheck<?= $taskId ?>" <?= $isDone ?>>
                                        <label for="todoCheck<?= $taskId ?>"></label>
                                    </div>
                                    <!-- todo text -->
                                    <span class="text"><?= $taskText ?></span>
                                    <!-- Emphasis label -->
                                    <small class="badge badge-info"><i class="far fa-clock"></i> <?= $createdAt ?></small>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <!-- You can trigger modal using data attributes -->
                                        <?php
                                        if ($isDoneCheck == 1) {
                                            echo "<form action='./handling.php' method='POST' class='d-inline'>"
                                                . "<input type='hidden' name='taskId' value='" . $taskId . "'>"
                                                . "<button type='submit' name='unCompleteTask' class='btn btn-sm btn-danger' title='Mark the Task Pending'><i class='fas fa-times-circle'></i></button>"
                                                . "</form>";
                                        } else {
                                            // echo "not done";
                                            echo "<form action='./handling.php' method='POST' class='d-inline'>"
                                                . "<input type='hidden' name='taskId' value='" . $taskId . "'>"
                                                . "<button type='submit' name='completeTask' class='btn btn-sm btn-success' title='Mark the Task Complete'><i class='fas fa-check'></i></button>"
                                                . "</form>";
                                        }
                                        ?>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalForEdit" data-task-id="<?= $taskId ?>" data-task-text="<?= $taskText ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="./handling.php" method="POST" class="d-inline">
                                            <input type="hidden" name="taskId" value="<?= $taskId ?>">
                                            <button type="submit" name="deleteTask" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                        <?php
                            }
                        } elseif (!empty($_SESSION['error2'])) {
                            echo '<li><span class="text text-danger">Error: ' . htmlspecialchars($_SESSION['error2']) . '</span></li>';
                            unset($_SESSION['error2']);
                        } else {
                            echo '<li><span class="text">No tasks found</span></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php include './footer.php' ?>


    <!-- Modal For Edit -->
    <div class="modal fade" id="modalForEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="./handling.php" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="taskId" id="editTaskId">
                        <div class="mb-3">
                            <label for="editTaskText" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="editTaskText" name="taskText" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="updateTask" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function() {
            $('.todo-list').sortable({
                placeholder: 'sort-highlight',
                handle: '.handle',
                forcePlaceholderSize: true,
                zIndex: 999999
            });
        });
    </script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap 5 Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <!-- SortableJS for drag and drop (if not already included) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <!-- jQuery UI (only if you're using drag features from jQuery UI, optional) -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalForEdit');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const taskId = button.getAttribute('data-task-id');
                const taskText = button.getAttribute('data-task-text');

                // Fill modal inputs
                document.getElementById('editTaskId').value = taskId;
                document.getElementById('editTaskText').value = taskText;
            });
        });
    </script>


</body>

</html>