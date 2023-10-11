<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirmpassword = isset($_POST['confirmpassword']) ? trim($_POST['confirmpassword']) : '';

    // Check if any of the required fields are empty
    if (empty($name) || empty($email) || empty($password) || empty($confirmpassword)) {
        echo "All fields are required. Please fill in all the fields.";
    } elseif ($password !== $confirmpassword) {
        echo "Password and Confirm Password do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif (!is_strong_password($password)) {
        echo "Password is not strong enough. It should contain at least one uppercase letter, one number, and be at least 8 characters long.";
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

        // Check if the email is already in use
        $check_email = "SELECT * FROM signup WHERE email = ?";
        $stmt_check = $conn->prepare($check_email);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        if ($result->num_rows > 0) {
            echo "This email is already registered.";
        } else {
            // Hash the password securely (using bcrypt)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL query with prepared statements
            $stmt = $conn->prepare("INSERT INTO signup (name, email, password) VALUES (?, ?, ?");

            if ($stmt) {
                $stmt->bind_param("sss", $name, $email, $hashedPassword);

                if ($stmt->execute()) {
                    header("Location: registration_success.php");
                    exit;
                } else {
                    echo "Error: Registration failed.";
                }

                $stmt->close();
            } else {
                echo "Error: Database error.";
            }
        }

        $conn->close();
    }
}

// Function to check password strength
function is_strong_password($password) {
    return (preg_match("/[A-Z]/", $password) && preg_match("/[0-9]/", $password) && strlen($password) >= 8);
}
?>
