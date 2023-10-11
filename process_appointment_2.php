<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $department = $_POST["department"];
    $appointment_name = $_POST["appointment_name"];
    $appointment_email = $_POST["appointment_email"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];
    $phone = $_POST["phone"];

    // Check if any required field is empty
    if (empty($department) || empty($appointment_name) || empty($appointment_email) || empty($appointment_date) || empty($appointment_time) || empty($phone)) {
        echo "All fields are required. Please fill in all the fields.";
    } else {
        $servername = "localhost";
        $username = "root";
        $password = ""; // Leave this as an empty string for no password
        $dbname = "dentacare";

        // Create a connection to the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert data into the database using prepared statements
        $sql = "INSERT INTO appointments2 (department, appointment_name, appointment_email, appointment_date, appointment_time, phone) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssss", $department, $appointment_name, $appointment_email, $appointment_date, $appointment_time, $phone);

            if ($stmt->execute()) {
                // Data inserted successfully
                header("Location: appointment_submitted.html");
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
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
