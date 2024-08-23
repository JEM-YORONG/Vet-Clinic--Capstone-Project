<?php
require "database-conn.php";
require 'timezone.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "checker") {
        checker();
    }
    if ($_POST["action"] == "forgot") {
        forgot();
    }
}

function checker()
{
    global $conn;

    $username = isset($_POST["username"]) ? htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8') : '';
    $password = isset($_POST["password"]) ? htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8') : '';

    $dateAndTime = new DateTime();

    // Get the current date
    $date = $dateAndTime->format('Y-m-d');

    // Get the current time
    $time = $dateAndTime->format('g:i A');

    // Validate the username and password
    if (empty($username)) {
        echo "Invalid email!";
        exit;
    }
    if (empty($password)) {
        echo "Invalid password!";
        exit;
    }

    // Prepare the SQL statement with placeholders for staff login
    $query = "SELECT * FROM staffs WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query returned any rows for staff login
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($row['role'] == 'Admin') {
            $role = "admin";
            $action = "Logged in.";
            $query = "UPDATE login SET date = '$date', time = '$time', role = '$role', user = '$username', action = '$action' WHERE id = '1'";
            $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
            mysqli_query($conn, $query);
            mysqli_query($conn, $logs);
            mysqli_close($conn);
        } elseif ($row['role'] == 'Secretary') {
            $role = "secretary";
            $action = "Logged in.";
            $query = "UPDATE login SET date = '$date', time = '$time', role = '$role', user = '$username', action = '$action' WHERE id = '1'";
            $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
            mysqli_query($conn, $query);
            mysqli_query($conn, $logs);
            mysqli_close($conn);
        } elseif ($row['role'] == 'Veterinarian') {
            $role = "veterinarian";
            $action = "Logged in.";
            $query = "UPDATE login SET date = '$date', time = '$time', role = '$role', user = '$username', action = '$action' WHERE id = '1'";
            $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
            mysqli_query($conn, $query);
            mysqli_query($conn, $logs);
            mysqli_close($conn);
        } else {
            // Login failed
            echo "Invalid email or password!";
            $role = "";
        }

        // Login successful
        echo $role;
    } else {
        // Login failed
        echo "Invalid email or password!";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}


function forgot()
{
    global $conn;

    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8') : '';
    $contact = isset($_POST["contact"]) ? htmlspecialchars($_POST["contact"], ENT_QUOTES, 'UTF-8') : '';

    // Validate the email and contact
    if (empty($email) || empty($contact)) {
        echo "Invalid email or contact!";
        exit;
    }

    // Check if email contains "@gmail.com"
    if (strpos($email, "@gmail.com") === false) {
        echo "Invalid email!";
        exit;
    }

    // Check if contact is an 11-digit number
    if (!preg_match('/^\d{11}$/', $contact)) {
        echo "Contact must be an 11-digit number!";
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM staffs WHERE email = ? AND contact = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        //echo "Database error!";
        exit;
    }

    // Bind parameters and execute the query
    $stmt->bind_param("ss", $email, $contact);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userName = $user['name'];
        // User found, generate a unique password
        $newPassword = generateUniquePassword();
        //echo "Hello, $userName Your email and new password is: $email - $newPassword";

        // Update the user's password in the database
        $updateQuery = "UPDATE staffs SET password = ? WHERE email = ? AND contact =?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sss", $newPassword, $email, $contact);
        $updateStmt->execute();

        require 'timezone.php';

        $query = "SELECT * FROM login WHERE id = '1'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        $dateAndTime = new DateTime();
        $date = $dateAndTime->format('Y-m-d');
        $time = $dateAndTime->format('g:i A');

        $username = $row['user'];

        $query2 = "SELECT * FROM staffs WHERE email = '$email'";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_array($result2);

        $role = $row2['role'];

        $action = "Resetted password.";

        $logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$email', '$action')";
        mysqli_query($conn, $logs);

        echo $newPassword;
    } else {
        echo "User not found!";
    }

    // Close the statement
    $stmt->close();
}

// Function to generate a unique password
function generateUniquePassword($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';

    // Generate a random password until a unique one is found
    do {
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        // Check if the generated password is unique in the database
    } while (isPasswordDuplicate($password));

    return $password;
}

// Function to check if a password already exists in the database
function isPasswordDuplicate($password)
{
    global $conn; // Assuming $conn is your database connection

    $query = "SELECT COUNT(*) as count FROM staffs WHERE password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'] > 0;
}
