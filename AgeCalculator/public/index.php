<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if(isset($_POST['clearsession'])){
        session_unset();
        header("Location: ./"); // Redirect back to show the result
        exit();
    }


    if (isset($_POST['checkAge'])) {
        $date = $_POST['dob'];

        if (!empty($date)) {
            $dob = new DateTime($date);
            $now = new DateTime();

            $diff = $dob->diff($now);

            $years = $diff->y;
            $months = $diff->m;
            $days = $diff->d;
            $hours = $diff->h;
            $minutes = $diff->i;

            // Calculate total days lived
            $totalDaysLived = $dob->diff($now)->days;

            $_SESSION['ageResult'] = "You have lived about {$years} Yr {$months} Month {$days} Days and {$hours} Hour. <br>
You have lived for a total of {$totalDaysLived} days.";
        } else {
            $_SESSION['ageResult'] = "Please enter a valid date.";
        }
        header("Location: ./"); // Redirect back to show the result
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./index.css">
    <title>Age Calculator</title>
</head>

<body>

    <div id="mainDiv">
        <?php require './header.php' ?>
        <div class="bg-secondary py-4" id="contentDiv">
            <div class="card col-md-6 mx-auto mt-3">
                <div class="d-flex justify-content-between align-items-center card-header bg-dark text-light"><p class="">Age Calculator</p> 
                <form action="" method="POST">
                    <button type="submit" name="clearsession" class="btn btn-sm btn-warning">Clear</button></div>
                </form>
                <div class="card-body">
                    <form action="" method="POST">
                        <label for="dob" class="text-dark mb-2">Date of Birth</label>
                        <input type="datetime-local" name="dob" id="dob" class="form-control">
                        <button type="submit" name="checkAge" class="btn btn-dark mt-3">Check Age</button>
                    </form>
                </div>
                <?php
                if (isset($_SESSION['ageResult'])) {
                    echo
                    "<div class='card-footer text-dark text-center'>"
                        . "<i><span class='text-danger'>Congratulations</span> : " . $_SESSION['ageResult'] . ".</i>"
                        . "</div>";
                }
                ?>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
        <?php require './footer.php' ?>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</html>