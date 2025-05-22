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
    <title>Todo App</title>
</head>

<body>
    <?php include "./navbar.php" ?>
    <div class="container">
        <div class="card mt-3 col-7 mx-auto">
            <div class="card-header bg-danger text-light">
                Todo Application
            </div>
            <div class="card-body">
                <form action="./handling.php" method="POST">
                    <label for="taskdesc">Task Description <span class="text-danger">*</span></label>
                    <textarea name="taskdesc" id="taskdesc" class="form-control mt-2" required placeholder="Enter Your Task" rows="3" autofocus></textarea>
                    <div class="text-center">
                        <input type="submit" name="createTask" class="btn btn-danger mt-2">
                    </div>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo '<div class="text-success">' . htmlspecialchars($_SESSION['msg']) . '</div>';
                        unset($_SESSION['msg']);
                    }
                    if (isset($_SESSION['error'])) {
                        echo '<div class="text-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                </form>
            </div>
        </div>
        <div class="mt-5">
            <table class="table table-bordered table-striped">
                <thead class="bg-dark text-light">
                    <tr>
                        <th>Sr. No</th>
                        <th>Task</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($result)) {
                        foreach ($result as $key => $res) {
                            echo "<tr>";
                            echo "<td>" . ($key + 1) . "</td>";
                            echo "<td class='text-capitalize'>" . htmlspecialchars($res['task']) . "</td>";
                            echo "<td>" . date('d-m-Y', strtotime($res['created_at'])) . "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-warning'>Edit</button>"."\t";
                            echo "<button class='btn btn-danger'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } elseif ($_SESSION['error2']) {
                        echo `
                            <tr>
                                <td colspan="4">Error : ` . htmlspecialchars($_SESSION['error2']) . `</td>
                            </tr>
                            `;
                        unset($_SESSION['error2']);
                    } else {
                        echo `   
                            <tr>
                                <td colspan="4">No Data Found</td>
                            </tr>
                            `;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>