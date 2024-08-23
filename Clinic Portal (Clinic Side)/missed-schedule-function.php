<?php
require 'database-conn.php';
date_default_timezone_set('Asia/Manila');

if (isset($_POST["action"])) {
    if ($_POST["action"] == "addAppointment") {
        add();
    }
    if ($_POST["action"] == "deleteSchedule") {
        delete();
    }
}

function add()
{
    global $conn;

    $date = $_POST["date"];
    $id = $_POST["id"];

    if (empty(trim($date))) {
        // At least one of the values is empty or only contains whitespace
        echo "Please fill in all the fields.";
        return;
    }

    // Convert the input date string to a DateTime object
    $inputDate = new DateTime($date);
    $currentDate = new DateTime();

    if ($inputDate < $currentDate) {
        $status = "Past";
    } else {
        $status = "Upcoming";
    }

    $reschedule = 'Rescheduled';

    // Update the date and status of the schedule
    $query = "UPDATE schedule SET date = ?, reschedule = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $date, $reschedule, $status, $id);

    if (mysqli_stmt_execute($stmt)) {

        $query1 = "SELECT * FROM schedule WHERE id = '$id'";
        $result1 = mysqli_query($conn, $query1);
        $row1 = mysqli_fetch_array($result1); // Fix typo here

        $name = $row1['ownername']; // Fix typo here
        mysqli_query($conn, $query1);

        $query2 = "SELECT * FROM login WHERE id = '1'";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_array($result2);

        $dateAndTime = new DateTime();
        $date = $dateAndTime->format('Y-m-d');
        $time = $dateAndTime->format('g:i A');

        $role = $row2['role'];
        $username = $row2['user'];

        $action = "Rescheduled " . $name . " missed appointment.";

        $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
        mysqli_query($conn, $logs);

        echo "Rescheduled successfully";
    } else {
        //echo "Error updating the schedule.";
    }

    mysqli_close($conn);
}



function delete()
{
    global $conn;

    $id = $_POST["rowId"];
    $name = $_POST["forShow"];

    $query = "DELETE FROM schedule WHERE id = '$id'";
    mysqli_query($conn, $query);
    echo "ScheduleDeletedSuccessfully";

    $query2 = "SELECT * FROM login WHERE id = '1'";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_array($result2);

    $dateAndTime = new DateTime();
    $date = $dateAndTime->format('Y-m-d');
    $time = $dateAndTime->format('g:i A');

    $role = $row2['role'];
    $username = $row2['user'];

    $action = "Deleted " . $name . " missed appointment.";

    $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
    mysqli_query($conn, $logs);
}
