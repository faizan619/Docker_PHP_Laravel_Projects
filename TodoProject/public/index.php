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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- DataTables core -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <!-- JSZip for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- pdfmake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Buttons for HTML5 export & print -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <title>Todo App</title>
</head>

<body>
    <?php include "./navbar.php" ?>
    <div class="container">
        <div class="card mt-3 col-7 mx-auto">
            <?php
            if (isset($_SESSION['msg'])) {
                echo '<div class="alert alert-primary text-center">' . htmlspecialchars($_SESSION['msg']) . '</div>';
                unset($_SESSION['msg']);
            }
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            ?>
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
                </form>
            </div>
        </div>
        <div class="mt-5">
            <table class="table table-bordered table-striped" id="taskTable">
                <thead class="bg-dark text-light">
                    <tr>
                        <th class="col-1">Sr. No</th>
                        <th class="col-7">Task</th>
                        <th class="col-2">Created At</th>
                        <th class="col-2 noExport ">Action</th>
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
                            echo "<td class='d-flex'>";
                            echo "<button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalForEdit'>Edit</button> &nbsp;" . "\t";
                            echo "<form action='./handling.php' method='POST'>
                            <input type='hidden' value=" . $res['id'] . " name='taskId' />
                            <button type='submit' name='deleteTask' class='btn btn-danger'>Delete</button></form>";
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
    <script>
        $(document).ready(function() {
            $('#taskTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(.noExport)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(.noExport)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(.noExport)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(.noExport)'
                        }
                    }
                ]
            });
        });
    </script>


</body>

<!-- Modal For Edit -->
<div class="modal fade" id="modalForEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


</html>