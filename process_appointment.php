<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_name = $_POST["appointment_name"];
    $appointment_email = $_POST["appointment_email"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];
    $appointment_message = $_POST["appointment_message"];

    // Check if any required field is empty
    if (empty($appointment_name) || empty($appointment_email) || empty($appointment_date) || empty($appointment_time) || empty($appointment_message)) {
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

        // Sanitize and validate user input

        // Insert data into the database using prepared statements
        $sql = "INSERT INTO appointments (appointment_name, appointment_email, appointment_date, appointment_time, appointment_message) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssss", $appointment_name, $appointment_email, $appointment_date, $appointment_time, $appointment_message);

            if ($stmt->execute()) {
                // Data inserted successfully
                echo "Appointment request submitted successfully.✅";
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
