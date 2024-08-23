<?php
require 'database-conn.php';
require 'timezone.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] === "addAppointment") {
        addAppointment();
    }
    if ($_POST["action"] === "deleteSchedule") {
        deleteSchedule();
    }
    // if ($_POST["action"] === "sendSMS") {
    //     sendSMS();
    // }
    if ($_POST["action"] === "updateAppointment") {
        updateAppointment();
    }
    if ($_POST["action"] === "statusDone") {
        statusDone();
    }
    if ($_POST["action"] === "getName") {
        display();
    }
    if ($_POST["action"] === "sentSMS") {
        sentSMS();
    }
}

function addAppointment()
{
    global $conn;

    $date = $_POST["date"];
    $name = $_POST["name"];
    $petname = $_POST["petname1"];
    $petname2 = $_POST["petname2"];
    $petname3 = $_POST["petname3"];
    $petname4 = $_POST["petname4"];
    $petname5 = $_POST["petname5"];
    $service1 = $_POST["service1"];
    $service2 = $_POST["service2"];
    $service3 = $_POST["service3"];
    $number = $_POST["number"];
    $customerName = "";
    $status = "";


    if (empty(trim($date)) || empty(trim($name)) || empty(trim($number))) {
        // At least one of the values is empty or only contains whitespace
        echo "Please fill in all the fields";
        return;
    }
    if (strlen($number) !== 11 || !ctype_alnum($number)) {
        echo "Contact must be 11 digit";
        return;
    }

    // Query the customer data based on the given name
    $query = "SELECT * FROM customer WHERE CONCAT(firstname, ' ', lastname) = '$name'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $customerName = $name;
        $ownerId = $row["id"]; // Get the customer's ID

        // Convert the input date string to a DateTime object
        $inputDate = new DateTime($date);
        $currentDate = new DateTime();

        if ($inputDate < $currentDate) {
            $status = "Past";
        } elseif ($inputDate > $currentDate) {
            $status = "Upcoming";
        }

        // Create an array of services
        $services = [$service1, $service2, $service3];

        // Insert the appointment into the database with the determined status
        $query = "INSERT INTO schedule (ownerid, ownername, petname, petname2, petname3, petname4, petname5, service, service2, service3, date, number, status, status2) VALUES ('$ownerId', '$customerName', '$petname', '$petname2', '$petname3', '$petname4', '$petname5', '$services[0]', '$services[1]', '$services[2]', '$date', '$number', '$status', '$status')";

        if (mysqli_query($conn, $query)) {
            echo "ScheduleAddedSuccessfully";

            $query = "SELECT * FROM login WHERE id = '1'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);

            $dateAndTime = new DateTime();
            $date = $dateAndTime->format('Y-m-d');
            $time = $dateAndTime->format('g:i A');

            $role = $row['role'];
            $username = $row['user'];

            $action = "Added " . $customerName . " appointment.";

            $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
            mysqli_query($conn, $logs);
        } else {
            echo "Error inserting schedule: " . mysqli_error($conn);
        }
    } else {
        echo "CustomerDidntExist";
    }
}

function updateAppointment()
{
    global $conn;

    $id = $_POST["updateId"];
    $date = $_POST["updatedate"];
    $name = $_POST["updatename"];
    $number = $_POST["updatenumber"];

    if (empty(trim($date))) {
        // At least one of the values is empty or only contains whitespace
        echo "Please fill in all the fields";
        return;
    }
    if (strlen($number) !== 11 || !ctype_alnum($number)) {
        echo "Contact must be 11 digit";
        return;
    }

    //default
    $petname = $_POST["updatepetname1"];
    $petname2 = $_POST["updatepetname2"];
    $petname3 = $_POST["updatepetname3"];
    $petname4 = $_POST["updatepetname4"];
    $petname5 = $_POST["updatepetname5"];
    //modified
    $petnameUpdate = $_POST["updatepetname12"];
    $petname2Update = $_POST["updatepetname22"];
    $petname3Update = $_POST["updatepetname32"];
    $petname4Update = $_POST["updatepetname42"];
    $petname5Update = $_POST["updatepetname52"];

    //holders
    $p1 = $petnameUpdate;
    $p2 = $petname2Update;
    $p3 = $petname3Update;
    $p4 = $petname4Update;
    $p5 = $petname5Update;
    //empty value checker
    if ($petnameUpdate == "") {
        $p1 = $petname;
    }
    if ($petname2Update == "") {
        $p2 = $petname2;
    }
    if ($petname3Update == "") {
        $p3 = $petname3;
    }
    if ($petname4Update == "") {
        $p4 = $petname4;
    }
    if ($petname5Update == "") {
        $p5 = $petname5;
    }
    if ($petnameUpdate == "r") {
        $p1 = "";
    }
    if ($petname2Update == "r") {
        $p2 = "";
    }
    if ($petname3Update == "r") {
        $p3 = "";
    }
    if ($petname4Update == "r") {
        $p4 = "";
    }
    if ($petname5Update == "r") {
        $p5 = "";
    }

    $service1 = $_POST["updateservice1"];
    $service2 = $_POST["updateservice2"];
    $service3 = $_POST["updateservice3"];

    $currentDate = date('Y-m-d');
    $statusUpdate = "";

    if ($date > $currentDate) {
        $statusUpdate = 'Upcoming';
    } elseif ($date == $currentDate) {
        $statusUpdate = 'Today';
    } else {
        $statusUpdate = 'Past';
    }

    $query = "UPDATE schedule SET ownername = '$name', petname = '$p1', petname2 = '$p2', petname3 = '$p3', petname4 = '$p4', petname5 = '$p5', service = '$service1', service2 = '$service2', service3 = '$service3', date = '$date', number = '$number', status = '$statusUpdate', status2 = '$statusUpdate' WHERE id = '$id'";

    mysqli_query($conn, $query);
    echo "ScheduleUpdatedSuccessfully";

    $query2 = "SELECT * FROM login WHERE id = '1'";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_array($result2);

    $dateAndTime = new DateTime();
    $date = $dateAndTime->format('Y-m-d');
    $time = $dateAndTime->format('g:i A');

    $role = $row2['role'];
    $username = $row2['user'];

    $action = "Updated " . $name . " appointment.";

    $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
    mysqli_query($conn, $logs);
}

function statusDone()
{
    global $conn;

    $statusId = $_POST["statusId"];
    $name = $_POST["forShow"];
    $status = "Done";

    $query = "UPDATE schedule SET status = '$status' WHERE id = '$statusId'";
    mysqli_query($conn, $query);

    $query2 = "SELECT * FROM login WHERE id = '1'";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_array($result2);

    $dateAndTime = new DateTime();
    $date = $dateAndTime->format('Y-m-d');
    $time = $dateAndTime->format('g:i A');

    $role = $row2['role'];
    $username = $row2['user'];

    $action = "Marked as " . $status . " " . $name . " appointment.";

    $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
    mysqli_query($conn, $logs);

    //echo "Done";
}


function deleteSchedule()
{
    global $conn;

    $id = $_POST["id"];
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

    $action = "Deleted " . $name . " appointment.";

    $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
    mysqli_query($conn, $logs);
}

// function sendSMS()
// {
//     //info
//     $smsDate = $_POST["smsDate"];
//     $smsNumber = "+639217214912"; //$_POST["smsNumber"]; //default muna
//     $smsName = $_POST["smsName"];
//     $smsPetname = $_POST["smsPetname"];
//     $smsMessage = $_POST["smsMessage"];

//     //$smsbody = "Hello " . $smsName . ", " . $smsMessage . " ";

//     require 'sms\index.php';

//     echo send($smsNumber, $smsMessage);
// }

function display()
{
    global $conn;

    if (isset($_POST['updatename'])) {
        $name = $_POST["updatename"];

        //echo $name;

        $query = "SELECT * FROM pet WHERE CONCAT(ownerfirstname, ' ',ownerlastname) = '$name'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<option value=''>Select a pet</option>";
            echo "<option value='r'>Remove</option>";
            while ($row = mysqli_fetch_assoc($result)) {
                $petname = $row["petname"];
                echo "<option value='$petname'>$petname</option>";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Customer name not provided.";
    }

    mysqli_close($conn);
}

function sentSMS()
{
    global $conn;

    $name = $_POST["forShow"];

    $query2 = "SELECT * FROM login WHERE id = '1'";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_array($result2);

    $dateAndTime = new DateTime();
    $date = $dateAndTime->format('Y-m-d');
    $time = $dateAndTime->format('g:i A');

    $role = $row2['role'];
    $username = $row2['user'];

    $action = "Sent appontment reminders to " . $name . ".";

    $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
    mysqli_query($conn, $logs);
}
