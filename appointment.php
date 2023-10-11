<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $time = $_POST["time"];
    $date = $_POST["date"];
    $message = $_POST["message"];

    if (empty($name) || empty($email) || empty($time) || empty($date) || empty($message)) {
        echo "All fields are required. Please fill in all the fields.";
    } else {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = ""; // Leave this as an empty string for no password
        $dbname = "testweb";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Prepare and execute the SQL query
        $stmt = $conn->prepare("INSERT INTO appointments (YourName, YourEmail, Subject, Message) VALUES (?, ?, ?, ?)");
    
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
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Preferred Time: " . $time . "<br>";
    echo "Preferred Date: " . $date . "<br>";
    echo "Message: " . $message . "<br>";
} else {
    // Redirect to the form page if accessed directly without submission
    header("Location: bookappointment.html");
    exit();
}
    }
}

?>
