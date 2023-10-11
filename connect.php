<?php
$YourName = isset($_POST['YourName']) ? htmlspecialchars($_POST['YourName']) : '';
$YourEmail = isset($_POST['YourEmail']) ? filter_var($_POST['YourEmail'], FILTER_SANITIZE_EMAIL) : '';
$Subject = isset($_POST['Subject']) ? htmlspecialchars($_POST['Subject']) : '';
$Message = isset($_POST['Message']) ? htmlspecialchars($_POST['Message']) : '';

// Check if any of the required fields are empty
if (empty($YourName) || empty($YourEmail) || empty($Subject) || empty($Message)) {
    echo "All fields are required. Please fill in all the fields.";
} else {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = ""; // Leave this as an empty string for no password
    $dbname = "dentacare";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO comment (YourName, YourEmail, Subject, Message) VALUES (?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssss", $YourName, $YourEmail, $Subject, $Message);

        if ($stmt->execute()) {
            // Redirect to the "Thank You" page
            header("Location: thank_you.html");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
