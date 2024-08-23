<?php
require 'database-conn.php';
require 'timezone.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "update") {
        update();
    }
    if ($_POST["action"] == "addPet") {
        addPet();
    }
    if ($_POST["action"] == "updatePet") {
        updatePet();
    }
    if ($_POST["action"] == "delete") {
        deletePet();
    }
    if ($_POST["action"] == "delete2") {
        deletePet2();
    }
    if ($_POST["action"] == "getPetID") {
        getPetID();
    }
    if ($_POST["action"] == "addPetRecord") {
        addPetRecord();
    }
    if ($_POST["action"] == "editPetRecord") {
        editPetRecord();
    }
}

function update()
{
    global $conn;
    // Customer info
    $custId = sanitizeInput($_POST['updateId']);
    $custLastName = sanitizeInput($_POST['updateLastName']);
    $custFirstName = sanitizeInput($_POST['updateFirstName']);
    $custContact = sanitizeInput($_POST['updateContact']);
    $custEmail = sanitizeInput($_POST['updateEmail']);
    $custAddress = sanitizeInput($_POST['updateAddress']);

    // Validate input - customer and pet
    if (
        empty($custLastName) || empty($custFirstName) || empty($custContact) || empty($custAddress)
    ) {
        echo "emptyFields";
        return;
    } else if (strlen($custContact) !== 11 || !ctype_alnum($custContact)) {
        echo "Contact must be 11 digit";
    } else {
        // Prepare the SQL statement for customer name
        $query = "SELECT * FROM customer WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $custId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // 
        if (mysqli_num_rows($result) == 1) {
            $query = "UPDATE customer SET lastname = ?, firstname = ?, contact = ?, email = ?, address = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssssi", $custLastName, $custFirstName, $custContact, $custEmail, $custAddress, $custId);
            mysqli_stmt_execute($stmt);

            // Update the pet owner information
            $query2 = "UPDATE pet SET ownerfirstname = ?, ownerlastname = ?, ownercontact = ?, owneremail = ?, owneraddress = ? WHERE ownerid = ?";
            $stmt2 = mysqli_prepare($conn, $query2);
            mysqli_stmt_bind_param($stmt2, "sssssi", $custFirstName, $custLastName, $custContact, $custEmail, $custAddress, $custId);
            mysqli_stmt_execute($stmt2);

            echo "customerUpdated";

            $query2 = "SELECT * FROM login WHERE id = '1'";
            $result2 = mysqli_query($conn, $query2);
            $row2 = mysqli_fetch_array($result2);

            $dateAndTime = new DateTime();
            $date = $dateAndTime->format('Y-m-d');
            $time = $dateAndTime->format('g:i A');

            $role = $row2['role'];
            $username = $row2['user'];

            $action = "Updated customer " . $custFirstName . " " . $custLastName . " information.";

            $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
            mysqli_query($conn, $logs);
        }
    }
}

function sanitizeInput($input)
{
    // Remove leading/trailing white spaces
    $input = trim($input);
    // Remove backslashes
    $input = stripslashes($input);
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input);
    return $input;
}

function addPet()
{
    global $conn;

    //pet info
    $petId = $_POST["petId"];
    $petName = $_POST["petName"];
    $gender = $_POST["gender"];
    $birthDate = $_POST["birthDate"];
    $type = $_POST["type"];
    $breed = $_POST["breedd"];
    $species = $_POST["speciess"];

    //owner info
    $ownerId = $_POST["ownerId"];
    $ownerLastname = $_POST["ownerLastname"];
    $ownerFirstname = $_POST["ownerFirstname"];
    $ownerContact = $_POST["ownerContact"];
    $ownerEmail = $_POST["ownerEmail"];
    $ownerAddress = $_POST["ownerAddress"];

    if (
        empty($petName) || empty($gender) || empty($birthDate) || empty($breed) || empty($species)
    ) {
        echo "emptyFields";
        return;
    }

    $query = "INSERT INTO pet VALUES (
        '',
        '$petId',
        '$ownerId',
        '$petName',
        '$ownerFirstname',
        '$ownerLastname',
        '$ownerContact',
        '$ownerEmail',
        '$ownerAddress',
        '$birthDate',
        '$type',
        '$breed',
        '$species',
        '$gender'
    )";
    mysqli_query($conn, $query);
    echo "petAdded";


    $query2 = "SELECT * FROM login WHERE id = '1'";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_array($result2);

    $dateAndTime = new DateTime();
    $date = $dateAndTime->format('Y-m-d');
    $time = $dateAndTime->format('g:i A');

    $role = $row2['role'];
    $username = $row2['user'];

    $action = "Added pet " . $petName . ".";

    $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
    mysqli_query($conn, $logs);
}

function updatePet()
{
    global $conn;

    //pet info
    $id = sanitizeInput($_POST['id']);
    $name = sanitizeInput($_POST['name']);
    $breed = sanitizeInput($_POST['breed']);
    $species = sanitizeInput($_POST['species']);
    $birthdate = sanitizeInput($_POST['birthdate']);

    // Validate input - customer and pet
    if (
        empty($name) || empty($breed) || empty($species) || empty($birthdate)
    ) {
        echo "emptyFields";
    } else {
        // Prepare the SQL statement for customer name
        $query = "SELECT * FROM pet WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // 
        if (mysqli_num_rows($result) == 1) {
            $query = "UPDATE pet SET petname = ?, breed = ?, species = ?, birthdate = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $breed, $species, $birthdate, $id);
            mysqli_stmt_execute($stmt);

            echo "pedUpdated";


            $query2 = "SELECT * FROM login WHERE id = '1'";
            $result2 = mysqli_query($conn, $query2);
            $row2 = mysqli_fetch_array($result2);

            $dateAndTime = new DateTime();
            $date = $dateAndTime->format('Y-m-d');
            $time = $dateAndTime->format('g:i A');

            $role = $row2['role'];
            $username = $row2['user'];

            $action = "Updated pet " . $name . " information.";

            $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
            mysqli_query($conn, $logs);
        }
    }
}

function deletePet()
{
    global $conn;

    $id = $_POST["id"];
    $name = $_POST["forShow"];

    $query = "DELETE FROM pet WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "petDeleted";

        $query2 = "SELECT * FROM login WHERE id = '1'";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_array($result2);

        $dateAndTime = new DateTime();
        $date = $dateAndTime->format('Y-m-d');
        $time = $dateAndTime->format('g:i A');

        $role = $row2['role'];
        $username = $row2['user'];

        $action = "Deleted pet " . $name . ".";

        $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
        mysqli_query($conn, $logs);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function deletePet2()
{
    global $conn;

    $id = $_POST["idSearch"];
    $name = $_POST["forShow"];

    $query = "DELETE FROM petrecord WHERE nid = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "petRDeleted";

        $query2 = "SELECT * FROM login WHERE id = '1'";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_array($result2);

        $dateAndTime = new DateTime();
        $date = $dateAndTime->format('Y-m-d');
        $time = $dateAndTime->format('g:i A');

        $role = $row2['role'];
        $username = $row2['user'];

        $action = "Deleted pet " . $name . " record.";

        $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
        mysqli_query($conn, $logs);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function getPetID()
{
    global $conn;

    $petId = $_POST["id"];
    $petName = $_POST["name"];
    $ownerID = $_POST["ownerId"];

    $statusDone = 'Done';
    $statusUpcoming = 'Upcoming';

    // Query for done schedules
    $queryDone = "SELECT * FROM schedule WHERE status = ? AND ownerid = ?";
    $stmtDone = mysqli_prepare($conn, $queryDone);
    mysqli_stmt_bind_param($stmtDone, "ss", $statusDone, $ownerID);
    mysqli_stmt_execute($stmtDone);
    $resultDone = mysqli_stmt_get_result($stmtDone);

    $petRecordsDone = array();

    // Process done schedules
    if (mysqli_num_rows($resultDone) > 0) {
        while ($rowDone = mysqli_fetch_assoc($resultDone)) {
            $getDateDone = $rowDone["date"];
            $petArrayDone = array(
                $rowDone["petname"],
                $rowDone["petname2"],
                $rowDone["petname3"],
                $rowDone["petname4"],
                $rowDone["petname5"]
            );

            $serviceArrayDone = array(
                $rowDone["service"],
                $rowDone["service2"],
                $rowDone["service3"]
            );

            // Check if the petName exists in the petArray
            if (in_array($petName, $petArrayDone)) {
                $serviceStringDone = implode(', ', array_filter($serviceArrayDone)); // Combine services into a string

                $petRecordsDone[] = array(
                    'type' => 'done',
                    'date' => $getDateDone,
                    'services' => $serviceStringDone
                );
            }
        }
    }

    // Query for upcoming schedules
    $queryUpcoming = "SELECT * FROM schedule WHERE status = ? AND ownerid = ?";
    $stmtUpcoming = mysqli_prepare($conn, $queryUpcoming);
    mysqli_stmt_bind_param($stmtUpcoming, "ss", $statusUpcoming, $ownerID);
    mysqli_stmt_execute($stmtUpcoming);
    $resultUpcoming = mysqli_stmt_get_result($stmtUpcoming);

    $petRecordsUpcoming = array();

    // Process upcoming schedules
    if (mysqli_num_rows($resultUpcoming) > 0) {
        while ($rowUpcoming = mysqli_fetch_assoc($resultUpcoming)) {
            $getDateUpcoming = $rowUpcoming["date"];
            $petArrayUpcoming = array(
                $rowUpcoming["petname"],
                $rowUpcoming["petname2"],
                $rowUpcoming["petname3"],
                $rowUpcoming["petname4"],
                $rowUpcoming["petname5"]
            );

            // Check if the petName exists in the petArray
            if (in_array($petName, $petArrayUpcoming)) {
                $petRecordsUpcoming[] = array(
                    'type' => 'upcoming',
                    'nextDate' => $getDateUpcoming
                );
            }
        }
    }

    // Combine both done and upcoming records
    $allPetRecords = array_merge($petRecordsDone, $petRecordsUpcoming);

    if (!empty($allPetRecords)) {
        echo json_encode(array('status' => 'petRecords', 'data' => $allPetRecords));
    } else {
        echo "noPetr";
    }
}

function addPetRecord()
{
    global $conn;

    // add pet record data
    $rDate = $_POST["rDate"];
    $rId = $_POST["rId"];
    $rPet = $_POST["rPet"];
    $rService1 = $_POST["rService1"];
    $rService2 = $_POST["rService2"];
    $rService3 = $_POST["rService3"];
    $rV1 = $_POST["rV1"];
    $rV2 = $_POST["rV2"];
    $rV3 = $_POST["rV3"];
    $rWeight = $_POST["rWeight"];
    $rAbout = $_POST["rAbout"];
    $rNote = $_POST["rNote"];

    // Check for empty fields
    if (
        empty($rDate) || empty($rService1) || empty($rWeight)
    ) {
        // At least one field is empty
        echo "emptyFields";
        return;
    }

    // add next schedule data
    $nDate = $_POST["nDate"];
    $nId = $_POST["nId"];
    $nOwnerF = $_POST["nOwnerF"];
    $nOwnerL = $_POST["nOwnerL"];
    $nOwnerName = $nOwnerF . " " . $nOwnerL;
    $nPet = $_POST["nPet"];
    $nService1 = $_POST["nService1"];
    $nService2 = $_POST["nService2"];
    $nService3 = $_POST["nService3"];
    $nNumber = $_POST["nNumber"];
    $nStatus = "";

    $uniqueNumber = generateUniqueNumber();
    $nid = "";

    if ($uniqueNumber !== false) {
        $nid = $uniqueNumber;
    } else {
        $nid = "error";
    }

    // add pet record
    $query = "INSERT INTO petrecord (nid, date, ownerid, petname, service1, service2, service3, vaccine1, vaccine2, vaccine3, weight, about, note) VALUES ('$nid', '$rDate', '$rId', '$rPet','$rService1', '$rService2', '$rService3', '$rV1', '$rV2', '$rV3', '$rWeight', '$rAbout', '$rNote')";

    $query2 = "SELECT * FROM login WHERE id = '1'";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_array($result2);

    $dateAndTime = new DateTime();
    $date = $dateAndTime->format('Y-m-d');
    $time = $dateAndTime->format('g:i A');

    $role = $row2['role'];
    $username = $row2['user'];

    $action = "Added pet " . $rPet . " record.";

    $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
    mysqli_query($conn, $logs);

    if (mysqli_query($conn, $query)) {
        echo "sPetRecord";
    } else {
        echo "ePetRecord";
    }

    // add next scheduled
    // Convert the input date string to a DateTime object
    $inputDate = new DateTime($nDate);
    $currentDate = new DateTime();

    if ($inputDate < $currentDate) {
        $nStatus = "Past";
    } elseif ($inputDate > $currentDate) {
        $nStatus = "Upcoming";
    }
    // Create an array of services
    $services = [$nService1, $nService2, $nService3];

    // Insert the appointment into the database with the determined status
    $query2 = "INSERT INTO schedule (nid, ownerid, ownername, petname, service, service2, service3, date, number, status) VALUES ('$nid', '$nId', '$nOwnerName', '$nPet', '$services[0]', '$services[1]', '$services[2]', '$nDate', '$nNumber', '$nStatus')";
    mysqli_query($conn, $query2);
}

function editPetRecord()
{
    global $conn;

    // add pet record data
    $rDate = $_POST["eDate"];
    $rId = $_POST["eId"];
    $rPet = $_POST["ePet"];
    $rService1 = $_POST["eService1"];
    $rService2 = $_POST["eService2"];
    $rService3 = $_POST["eService3"];
    $rV1 = $_POST["eV1"];
    $rV2 = $_POST["eV2"];
    $rV3 = $_POST["eV3"];
    $rWeight = $_POST["eWeight"];
    $rAbout = $_POST["eAbout"];
    $rNote = $_POST["eNote"];

    // Check for empty fields
    if (
        empty($rDate) || empty($rService1)
    ) {
        // At least one field is empty
        echo "emptyFields";
        return;
    }

    $rID = $_POST["eRid"];

    // add next schedule data
    $nDate = $_POST["enDate"];
    $nId = $_POST["enId"];
    $nOwnerF = $_POST["enOwnerF"];
    $nOwnerL = $_POST["enOwnerL"];
    $nOwnerName = $nOwnerF . " " . $nOwnerL;
    $nPet = $_POST["nPet"];
    $nService1 = $_POST["enService1"];
    $nService2 = $_POST["enService2"];
    $nService3 = $_POST["enService3"];
    $nNumber = $_POST["enNumber"];
    $nStatus = "";

    // update pet record
    $query = "UPDATE petrecord
        SET date = '$rDate',
            petname = '$rPet',
            service1 = '$rService1',
            service2 = '$rService2',
            service3 = '$rService3',
            vaccine1 = '$rV1',
            vaccine2 = '$rV2',
            vaccine3 = '$rV3',
            weight = '$rWeight',
            about = '$rAbout',
            note = '$rNote'
        WHERE nid = $rID";

    if (mysqli_query($conn, $query)) {
        echo "esPetRecord";

        $query2 = "SELECT * FROM login WHERE id = '1'";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_array($result2);

        $dateAndTime = new DateTime();
        $date = $dateAndTime->format('Y-m-d');
        $time = $dateAndTime->format('g:i A');

        $role = $row2['role'];
        $username = $row2['user'];

        $action = "Updated pet " . $rPet . " record.";

        $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
        mysqli_query($conn, $logs);
    } else {
        echo "eePetRecord";
    }

    // Convert the input date string to a DateTime object
    $inputDate = new DateTime($nDate);
    $currentDate = new DateTime();

    if ($inputDate < $currentDate) {
        $nStatus = "Past";
    } elseif ($inputDate > $currentDate) {
        $nStatus = "Upcoming";
    }

    // Create an array of services
    $services = [$nService1, $nService2, $nService3];

    // Check if the row exists before updating
    $queryCheck = "SELECT * FROM schedule WHERE nid = '$rID'";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if ($resultCheck) {
        // Check if a row is returned
        if (mysqli_num_rows($resultCheck) > 0) {
            // Row exists, proceed with the update
            $queryUpdate = "UPDATE schedule
        SET ownername = '$nOwnerName',
            petname = '$nPet',
            service = '$services[0]',
            service2 = '$services[1]',
            service3 = '$services[2]',
            date = '$nDate',
            number = '$nNumber',
            status = '$nStatus'
        WHERE nid = '$rID'";
            mysqli_query($conn, $queryUpdate);
        } else {
            $queryInsert = "INSERT INTO schedule (nid, ownerid, ownername, petname, service, service2, service3, date, number, status) VALUES ('$rID', '$nId', '$nOwnerName', '$nPet', '$services[0]', '$services[1]', '$services[2]', '$nDate', '$nNumber', '$nStatus')";
            mysqli_query($conn, $queryInsert);
        }
    } else {
        // Handle query execution failure
        echo "Error executing the query: " . mysqli_error($conn);
    }
}

// Function to generate a random and unique 10-digit number
function generateUniqueNumber()
{
    global $conn;

    $uniqueNumber = mt_rand(1000000000, 9999999999);

    // Check if the generated number already exists in the database
    $query = "SELECT COUNT(*) as count FROM petrecord WHERE nid = '$uniqueNumber'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        // If the number already exists, generate a new one recursively
        if ($count > 0) {
            return generateUniqueNumber();
        } else {
            return $uniqueNumber;
        }
    } else {
        // Handle the case where the query fails
        return false;
    }
}
